from flask import Flask, flash, redirect,render_template, request, url_for
from flask_sqlalchemy import SQLAlchemy
import json
from flask_mail import Mail

with open('config.json', 'r') as c:
    params = json.load(c) ['params']

local_server = True
app = Flask(__name__)
app.config.update(
    MAIL_SERVER = 'smtp.gmail.com',
    MAIL_PORT = '465',
    MAIL_USE_SSL = True,
    MAIL_USERNAME = params['gmail_user'],
    MAIL_PASSWORD = params['gmail_pswd']
)
mail = Mail(app)

if(local_server):
    app.config['SQLALCHEMY_DATABASE_URI'] = params['local_uri']
else:
    app.config['SQLALCHEMY_DATABASE_URI'] = params['prod_uri']

app.config['SECRET_KEY'] = 'random_@beyond_imagination'
db = SQLAlchemy(app)


class Mytable(db.Model):
    '''sno email pass'''
    sno = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(50), unique=True, nullable=False)
    phone = db.Column(db.String(50), unique=True, nullable=False)
    email = db.Column(db.String(50), unique=True, nullable=False)
    content = db.Column(db.String(250), unique=False, nullable=True)


@app.route("/")
def hello_world():
    return render_template('index_cont.html', params = params)


@app.route("/about")
def second():
    return render_template('about.html')

@app.route("/contact")
def third():
    return render_template('contact.html')

@app.route("/form", methods = ['GET', 'POST'])
def submit():
    if(request.method == 'POST'):
       name = request.form.get('name')
       phone = request.form.get('phone')
       email = request.form.get('email')
       content = request.form.get('content')

       exist_name = Mytable.query.filter((Mytable.name == name)).first()
       exist_phone = Mytable.query.filter((Mytable.phone == phone)).first()
       exist_email = Mytable.query.filter((Mytable.email == email)).first()

       if exist_name and exist_phone and exist_email:
           flash('Duplicate name or phone number or email hasbeen used', 'warning')
           return render_template('index.html', params=params, old_name=name, old_phone=phone, old_email=email, old_content=content)
       elif exist_name:
           flash('Duplicate name hasbeen used', 'warning')
           return render_template('index.html', params=params, old_name=name, old_phone=phone, old_email=email, old_content=content)

       elif exist_phone:
           flash('Duplicate phone number hasbeen used', 'warning')
           return render_template('index.html', params=params, old_name=name, old_phone=phone, old_email=email, old_content=content)

       elif exist_email:
           flash('Duplicate email hasbeen used', 'warning')
           return render_template('index.html', params=params, old_name=name, old_phone=phone, old_email=email, old_content=content)


       ok = Mytable(name=name, phone=phone, email=email, content=content)
       db.session.add(ok)
       db.session.commit()
       mail.send_message("New id registered from: " + name,
                         sender = email,
                         recipients = [params['gmail_user']],
                         body = content + "\n" + phone
                         )
         
     #show = params['sub_msg']     
    # return show
    flash('Send successfully', 'success')
    return redirect(url_for('hello_world'))




app.run(debug=True,port=5001)