from datetime import datetime
import math
import os
from flask import Flask, flash, redirect, render_template, request, url_for, session
from flask_sqlalchemy import SQLAlchemy
from werkzeug.utils import secure_filename
import json
from flask_mail import Mail

with open('config.json', 'r') as c:
    params = json.load(c)['params']

local_server = True
app = Flask(__name__)
app.config['UPLOAD_LOCATION'] = params['file_loc']
app.config['PUB_LOCATION'] = params['file_loc2']
app.config.update(
    MAIL_SERVER='smtp.gmail.com',
    MAIL_PORT='465',
    MAIL_USE_SSL=True,
    MAIL_USERNAME=params['gmail_user'],
    MAIL_PASSWORD=params['gmail_pswd']
)
mail = Mail(app)

if local_server:
    app.config['SQLALCHEMY_DATABASE_URI'] = params['local_uri']
else:
    app.config['SQLALCHEMY_DATABASE_URI'] = params['prod_uri']

app.config['SECRET_KEY'] = 'random_@beyond_imagination'
db = SQLAlchemy(app)

class Hello(db.Model):
    sno = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(50), unique=True, nullable=False)
    email = db.Column(db.String(50), unique=True, nullable=False)
    phone = db.Column(db.String(50), unique=True, nullable=False)
    mes = db.Column(db.String(250), nullable=True)
    date = db.Column(db.String(50), nullable=False)


class Posts(db.Model):
    sno = db.Column(db.Integer, primary_key=True)
    title = db.Column(db.String(50), unique=True, nullable=False)
    date = db.Column(db.String(50), nullable=False)
    slug = db.Column(db.String(12), nullable=False)
    content = db.Column(db.String(120), nullable=False)
    image = db.Column(db.String(120), nullable=True)
    tagline = db.Column(db.String(50), nullable=True)


@app.route("/")
def home():
    posts=Posts.query.filter_by().all()
    page = request.args.get('page')
    last = math.ceil(len(posts)/4)

    if(not str(page).isnumeric()):
        page = 1
    page = int(page)

    posts = posts[(page-1) * 4:(page-1) * 4 + 4]

    #first
    if(page == 1):
        prev = '#'
        next = '/?page='+ str(page+1)
    #last
    elif(page == last):
        prev = '/?page='+ str(page-1)
        next = '#'
    #mid
    else:
        prev = '/?page='+ str(page-1)
        next = '/?page='+ str(page+1)

    return render_template('index.html', params=params, posts=posts, prev=prev, next=next)


@app.route("/logout")
def logot():
    session.pop('u_name')
    return redirect('/admin')



@app.route("/delete/<string:sno>", methods=['GET', 'POST'])
def delete(sno):
    if ('u_name' in session and session['u_name'] == params['uname']):
        post=Posts.query.filter_by(sno=sno).first()
        db.session.delete(post)
        db.session.commit()
    flash(sno+'th post has been deleted!!')
    return redirect('/admin')



@app.route("/upload", methods=['GET', 'POST'])
def upload():
    if ('u_name' in session and session['u_name'] == params['uname']):
        if request.method == 'POST':
            f = request.files['u_file']
            f.save(os.path.join(app.config['UPLOAD_LOCATION'], secure_filename(f.filename)))
            flash('✅ File Uploaded successfully')
            return redirect('/admin')



@app.route("/admin", methods=['GET', 'POST'])
def log():
    if ('u_name' in session and session['u_name'] == params['uname']):
        posts=Posts.query.all()
        return render_template('admin.html', params=params, posts=posts)
    
    if request.method == "POST":
        uname = request.form.get('user')
        password = request.form.get('password')
        if(uname == params['uname'] and password == params['pass']):
            session ['u_name'] = uname
            posts=Posts.query.all()
            return render_template('admin.html', params=params, posts=posts)
        
    return render_template('login.html', params=params)






@app.route("/edit/<string:sno>", methods=['GET', 'POST'])
def edit(sno):
     # ✅ Allow everyone to access /edit/0 (i.e., add post form)
    if sno != '0':
        if ('u_name' not in session or session['u_name'] != params['uname']):
            flash("⚠️ You must be logged in to edit existing posts.")
            return redirect('/admin')

    # if ('u_name' in session and session['u_name'] == params['uname']):
    if request.method == 'POST':
        title = request.form.get('title')
        date = datetime.now()
        slug = request.form.get('slug')
        content = request.form.get('content')
        # image = request.form.get('image')
        tagline = request.form.get('tagline')


        f = request.files.get('image')
        filename = None
        if f and f.filename != "":
            filename = secure_filename(f.filename)
            f.save(os.path.join(app.config['PUB_LOCATION'], filename))

        if sno == '0':
            image = filename if filename else ""
            post = Posts(title=title, date=date, slug=slug, content=content, image=image, tagline=tagline)
            db.session.add(post)
            db.session.commit()
            flash('✅New post added successfully..')
            return redirect('/')

        else: 
            post=Posts.query.filter_by(sno=sno).first()

            post.title=title
            post.date=date
            post.slug=slug
            post.content=content
            if filename:
                post.image=filename
            post.tagline=tagline
            
            db.session.commit()
            flash('✅ Edited successfully..You can leve the page..')
            return redirect('/admin')
        

        
    post=Posts.query.filter_by(sno=sno).first() if sno != '0' else None
    return render_template('edit.html', params=params, post=post, sno=sno)
    




@app.route("/post/<string:post_slug>", methods=['GET'])
def post_route(post_slug):
    post = Posts.query.filter_by(slug=post_slug).first()
    return render_template('post.html', params=params, post=post)



@app.route("/about")
def second():
    return render_template('about.html', params=params)


@app.route("/contact", methods=['GET', 'POST'])
def contact():
    if request.method == 'POST':
        name = request.form.get('name')
        email = request.form.get('email')
        phone = request.form.get('phone')
        message = request.form.get('message')

        #  Check duplicate
        duplicate = Hello.query.filter(
            (Hello.name == name) | (Hello.email == email) | (Hello.phone == phone)
        ).first()

        if duplicate:
            flash("❌ Duplicate entry! Try with different name/email/phone.")
            return render_template('contact.html', params=params, old_name=name, old_email=email, old_phone=phone, old_message=message)
        else:

            #  Save only if not duplicate
            entry = Hello(name=name, email=email, phone=phone, mes=message, date=str(datetime.now()))
            db.session.add(entry)
            db.session.commit()
            flash("✅ Successfully submitted!")

            #  Send mail only for new entry
            mail.send_message("New message from: " + name,
                              sender=email,
                              recipients=[params['gmail_user']],
                              body=message + "\nPhone: " + phone)

        return redirect(url_for('contact'))

    return render_template('contact.html', params=params)

app.run(debug=True, port=5001)
