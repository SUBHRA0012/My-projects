-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2026 at 11:53 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `grocery`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `password`, `date`) VALUES
(1, 'admin1', 'admin123', '2026-02-19 19:30:22');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`) VALUES
(1, 'fruits'),
(2, 'vegatables'),
(3, 'nonveg'),
(4, 'dairy'),
(5, 'tea');

-- --------------------------------------------------------

--
-- Table structure for table `detailsproduct`
--

CREATE TABLE `detailsproduct` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `detail_desc` text NOT NULL,
  `thumb_img1` varchar(255) NOT NULL,
  `thumb_img2` varchar(255) NOT NULL,
  `thumb_img3` varchar(255) NOT NULL,
  `thumb_img4` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detailsproduct`
--

INSERT INTO `detailsproduct` (`id`, `product_id`, `detail_desc`, `thumb_img1`, `thumb_img2`, `thumb_img3`, `thumb_img4`, `date`) VALUES
(1, 1, 'A medium apple (about 182g with skin) offers around 95-104 calories, ~25g carbs (mostly natural sugars & fiber), ~4.4g fiber (pectin), <1g protein, negligible fat, and is a good source of Vitamin C, Potassium, and antioxidants like quercetin, with benefits for heart health, digestion, and blood sugar control, especially when eaten unpeeled for maximum fiber and nutrients.', 'apple1.png', 'apple2.png', 'apple3.png', 'apple4.png', '2026-02-07 17:51:15'),
(2, 2, 'A 100g serving of skinless chicken breast provides approximately 157–165 calories, 31g of high-quality protein, and only 3.6g of fat, making it excellent for muscle repair and weight management.', 'chicken1.png', 'chicken2.png', 'chicken3.png', 'chicken4.png', '2026-02-07 18:32:05'),
(3, 3, 'One cup of raw cabbage (89g) provides 22 calories, 5.2 grams of\r\ncarbohydrates, 2.2 grams of fiber, 1.1 grams of protein, 0.1 grams of\r\nfat, and 16 mg of sodium. Cabbage is a low-calorie and nutrient-rich\r\nvegetable. It contains vitamin C, vitamin A, vitamin K, potassium,\r\ncalcium, manganese, and magnesium.', 'cabbage1.png', 'cabbage2.png', 'cabbage3.png', 'cabbage4.png', '2026-02-07 18:38:30'),
(4, 4, 'Nutrition_per: 100g Energy, kcal: 86.4 kcal Total Carbohydrate, g: 5.0 g Total fat, g: 6.0 g Added Sugar, g: 0.0 g Saturated Fat, g: 3.9 g Protein, g: 3.1 g Trans Fat, g: 0 g Calcium, mg: 108.0 mg', 'amulmilk1.png', 'amulmilk2.png', 'amulmilk3.png', 'amulmilk4.png', '2026-02-07 18:39:05'),
(5, 5, 'A 3.5-ounce (100-gram) cooked serving provides roughly 180–200 calories, 22–25 grams of protein, and 8–12 grams of healthy fat, with zero carbohydrates', 'salmonfish1.png', 'salmonfish2.png', 'salmonfish3.png', 'salmonfish4.png', '2026-02-07 18:40:04'),
(6, 6, 'A medium baked potato (with skin) offers ~160 calories, ~37g carbs, 4g fiber, and 4.6g protein, plus significant Vitamin C, Potassium (more than bananas!), and Vitamin B6, while naturally being fat-free, sodium-free, and cholesterol-free, making them nutrient-dense energy sources with important antioxidants and minerals.', 'potato1.png', 'potato2.png', 'potato3.png', 'potato4.png', '2026-02-07 18:40:36'),
(7, 7, ' A medium tomato offers around 22 calories, while a 100g serving provides about 18 calories, water, fiber, carbs, and small amounts of protein and fat, making them a nutrient-dense, heart-healthy food.', 'tomato1.png', 'tomato2.png', 'tomato3.png', 'tomato4.png', '2026-02-07 18:41:31'),
(8, 8, 'Capsicum (bell peppers) are low-calorie (approx. 26-31 kcal/100g), nutrient-dense vegetables consisting of 92-94% water. They are exceptionally high in Vitamin C (up to 317% DV in red), Vitamin A, Vitamin B6, and potassium, alongside antioxidants like lutein and beta-carotene. Key nutrients per 100g include ~6g carbs, ~2g fiber, and <0.5g fat. ', 'capsicum1.png', 'capsicum2.png', 'capsicum3.png', 'capsicum4.png', '2026-02-07 18:41:31'),
(9, 9, 'Yellow capsicum (yellow bell pepper) is a highly nutritious, low-calorie, and sweet-tasting vegetable packed with Vitamin C, providing over 200% of the daily value per medium pepper. It is rich in antioxidants like lutein and quercetin, supporting immunity, eye health, and skin health. A 100g serving contains approximately 27-32 kcal, 6g carbs, and 1g protein, making it excellent for heart-healthy diets. ', 'capsicumYellow1.png', 'capsicumYellow2.png', 'capsicumYellow3.png', 'capsicumYellow4.png', '2026-02-07 18:42:45'),
(32, 65, 'Sweet potatoes are highly nutritious root vegetables, often considered a superfood for being packed with vitamins, minerals, fiber, and antioxidants. A single medium-sized sweet potato provides over 400% of the daily value for vitamin A, crucial for immune function, skin, and vision. They are low in fat and contain around 3-4g of fiber per serving.', 'sweetpotato1.png', 'sweetpotato2.png', 'sweetpotato3.png', 'sweetpotato4.png', '2026-02-21 22:36:41'),
(33, 66, 'Per 100 grams, raw carrots provide approximately 35–41 kcal, 0.2–0.3g fat, 6–9g carbohydrates, 2.8–3.6g fiber, and 0.9g protein. They are exceptionally high in Vitamin A (via beta-carotene), often providing over 100% of the daily value, and contain significant amounts of potassium, vitamin K, and fiber.', 'carrotorange1.png', 'carrotorange2.png', 'carrotorange3.png', 'carrotorange4.png', '2026-02-21 22:43:06');

-- --------------------------------------------------------

--
-- Table structure for table `message_customer`
--

CREATE TABLE `message_customer` (
  `sno` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message_customer`
--

INSERT INTO `message_customer` (`sno`, `name`, `email`, `subject`, `message`, `date`, `status`) VALUES
(1, 'rani rai', 'ranji@gmail.com', 'blocked my account', 'why you blocked my account?', '2026-02-24 15:22:56', 1),
(2, 'Subham Das', 'das@email.com', 'review of website', 'your website is nice, keep going', '2026-02-24 15:29:07', 1),
(3, 'asc', 'sub@sub.com', 'ssacc', 'adsf', '2026-02-24 15:30:09', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL DEFAULT 'COD',
  `payment_status` varchar(50) NOT NULL DEFAULT 'Pending',
  `order_status` varchar(50) NOT NULL DEFAULT 'Placed',
  `order_ref_id` varchar(50) NOT NULL,
  `dt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `address_id`, `total_amount`, `payment_method`, `payment_status`, `order_status`, `order_ref_id`, `dt`) VALUES
(1, 1, 1, 652, 'COD', 'Pending', 'Delivered', 'ORD-XT93KLM8QAZW', '2026-02-15 00:00:22'),
(2, 12, 5, 60, 'COD', 'Pending', 'Cancelled', 'ORD-QEG5IX489YAF', '2026-02-15 13:41:41'),
(3, 1, 1, 140, 'COD', 'Pending', 'Delivered', 'ORD-9N86JDGQA10K', '2026-02-15 18:46:51'),
(4, 1, 1, 25, 'COD', 'Pending', 'Cancelled', 'ORD-QRKOD82H4JA6', '2026-02-15 19:19:50'),
(5, 1, 1, 13, 'COD', 'Pending', 'Cancelled', 'ORD-ZFW5HKIRE4AX', '2026-02-15 19:19:58'),
(6, 1, 3, 120, 'COD', 'Pending', 'Delivered', 'ORD-9HMD8VU5E24Q', '2026-02-16 18:07:12'),
(7, 11, 7, 711, 'COD', 'Pending', 'Shipped', 'ORD-QLXI8DY7APZ5', '2026-02-17 14:07:35'),
(8, 1, 1, 68, 'COD', 'Pending', 'Delivered', 'ORD-J6UQI1S70A2O', '2026-02-17 21:13:34'),
(9, 3, 8, 140, 'COD', 'Pending', 'Cancelled', 'ORD-JHLM3BZ6E2XF', '2026-02-17 21:18:52'),
(10, 3, 8, 345, 'COD', 'Pending', 'Cancelled', 'ORD-0YW9VPXS5GMI', '2026-02-17 21:36:09'),
(11, 3, 8, 26, 'COD', 'Pending', 'Cancelled', 'ORD-UAIOW30T5P9V', '2026-02-17 21:38:50'),
(12, 3, 8, 13, 'COD', 'Pending', 'Cancelled', 'ORD-FEOQ9AZS1BWD', '2026-02-17 21:39:56'),
(13, 3, 8, 140, 'COD', 'Pending', 'Cancelled', 'ORD-P2L16AWSFG5Q', '2026-02-17 21:42:09'),
(14, 3, 8, 26, 'COD', 'Pending', 'Cancelled', 'ORD-T06GK8WDLA19', '2026-02-17 21:43:51'),
(15, 3, 8, 13, 'COD', 'Pending', 'Cancelled', 'ORD-Q3OJFRH0VLEA', '2026-02-17 21:44:17'),
(16, 3, 8, 140, 'COD', 'Pending', 'Cancelled', 'ORD-6KPTZ2WX0D71', '2026-02-17 21:45:49'),
(17, 3, 8, 25, 'COD', 'Pending', 'Cancelled', 'ORD-Y16WH0ZNMOUS', '2026-02-17 21:46:21'),
(18, 3, 8, 140, 'COD', 'Pending', 'Cancelled', 'ORD-MI21VNLWUB5J', '2026-02-17 21:49:31'),
(19, 1, 1, 900, 'COD', 'Pending', 'Cancelled', 'ORD-EC3FS5OKPZR1', '2026-02-19 14:49:07'),
(20, 1, 1, 900, 'COD', 'Pending', 'Cancelled', 'ORD-U4MZYA29KJQS', '2026-02-19 14:49:16'),
(21, 1, 1, 900, 'COD', 'Pending', 'Delivered', 'ORD-DCEZK2GM0XSW', '2026-02-19 14:49:22'),
(22, 1, 1, 900, 'COD', 'Pending', 'Cancelled', 'ORD-ENHGAZ6U7XDP', '2026-02-19 14:49:31'),
(23, 1, 1, 900, 'COD', 'Pending', 'Cancelled', 'ORD-ODRCN72LUEF3', '2026-02-19 14:49:40'),
(24, 1, 1, 900, 'COD', 'Pending', 'Cancelled', 'ORD-XRB9A08LDHOS', '2026-02-19 14:50:10'),
(25, 1, 1, 900, 'COD', 'Pending', 'Cancelled', 'ORD-9TZFX3Q6JCAH', '2026-02-19 14:50:20'),
(26, 1, 1, 900, 'COD', 'Pending', 'Cancelled', 'ORD-OFEY3Z9QI857', '2026-02-19 14:50:33'),
(27, 1, 1, 900, 'COD', 'Pending', 'Cancelled', 'ORD-47CUMWXP6921', '2026-02-19 14:53:13'),
(28, 1, 1, 900, 'COD', 'Pending', 'Cancelled', 'ORD-8N1DGFYPOC7K', '2026-02-19 14:53:21'),
(29, 1, 1, 900, 'COD', 'Pending', 'Cancelled', 'ORD-09KG8OFEBDM5', '2026-02-19 14:55:28'),
(30, 1, 1, 240, 'COD', 'Pending', 'Cancelled', 'ORD-L19HXFK83N4B', '2026-02-19 15:00:13'),
(31, 1, 1, 140, 'COD', 'Pending', 'Cancelled', 'ORD-72CPRGVO0AY6', '2026-02-19 15:00:54'),
(32, 1, 1, 3105, 'COD', 'Pending', 'Cancelled', 'ORD-4HNT6V0QCJ1W', '2026-02-19 15:06:01'),
(33, 12, 4, 1725, 'COD', 'Pending', 'Placed', 'ORD-4Y8W1JBPX3L6', '2026-02-19 15:10:07'),
(34, 11, 6, 512, 'COD', 'Pending', 'Placed', 'ORD-9CEJG8WXOPFQ', '2026-02-22 14:28:54'),
(35, 12, 5, 7548, 'COD', 'Pending', 'Placed', 'ORD-0IERO234PQCM', '2026-02-22 16:37:14'),
(36, 1, 1, 365, 'COD', 'Pending', 'Placed', 'ORD-HOEJF7Y5W306', '2026-02-24 15:53:38'),
(37, 1, 1, 368, 'COD', 'Pending', 'Placed', 'ORD-NC8VI2YKLPR5', '2026-02-25 03:09:09'),
(38, 13, 9, 1135, 'COD', 'Pending', 'Placed', 'ORD-SMIFQCUVBDNA', '2026-02-25 14:26:42');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`item_id`, `order_id`, `product_id`, `qty`, `price`) VALUES
(1, 1, 1, 9, 25),
(2, 1, 3, 3, 26),
(3, 1, 4, 3, 13),
(4, 1, 2, 2, 140),
(5, 1, 7, 1, 30),
(6, 2, 6, 3, 20),
(7, 3, 2, 1, 140),
(8, 4, 1, 1, 25),
(9, 5, 4, 1, 13),
(10, 6, 7, 4, 30),
(11, 7, 3, 1, 26),
(12, 7, 2, 4, 140),
(13, 7, 1, 5, 25),
(14, 8, 8, 1, 68),
(15, 9, 2, 1, 140),
(16, 10, 5, 1, 345),
(17, 11, 3, 1, 26),
(18, 12, 4, 1, 13),
(19, 13, 2, 1, 140),
(20, 14, 3, 1, 26),
(21, 15, 4, 1, 13),
(22, 16, 2, 1, 140),
(23, 17, 1, 1, 25),
(24, 18, 2, 1, 140),
(25, 19, 9, 8, 113),
(26, 20, 9, 8, 113),
(27, 21, 9, 8, 113),
(28, 22, 9, 8, 113),
(29, 23, 9, 8, 113),
(30, 24, 9, 8, 113),
(31, 25, 9, 8, 113),
(32, 26, 9, 8, 113),
(33, 27, 9, 8, 113),
(34, 28, 9, 8, 113),
(35, 29, 9, 8, 113),
(36, 30, 6, 12, 20),
(37, 31, 2, 1, 140),
(38, 32, 5, 9, 345),
(39, 33, 5, 5, 345),
(40, 34, 3, 2, 26),
(41, 34, 6, 2, 20),
(42, 34, 2, 3, 140),
(43, 35, 66, 12, 79),
(44, 35, 4, 12, 65),
(45, 35, 5, 12, 345),
(46, 35, 2, 12, 140),
(47, 36, 6, 1, 20),
(48, 36, 5, 1, 345),
(49, 37, 1, 3, 25),
(50, 37, 8, 1, 68),
(51, 37, 9, 2, 113),
(52, 38, 5, 3, 345),
(53, 38, 6, 5, 20);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(25) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `old_price` decimal(10,2) NOT NULL,
  `parent_product` varchar(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `product_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `product_name`, `price`, `old_price`, `parent_product`, `image`, `stock`, `date`, `product_desc`) VALUES
(1, 1, 'apple', 25.00, 25.00, 'apple', 'apple.png', 11, '2026-02-04 14:38:58', 'Enjoy the crisp, refreshing taste of Shimla\'s finest regular apples, hand-picked for their quality and flavour. These apples embody freshness and are perfect for snacking or adding a sweet crunch to salads and desserts.'),
(2, 3, 'chicken', 140.00, 240.00, 'chicken', 'chicken.png', 40, '2026-02-04 14:38:58', 'FreshtoHome Chicken - Skinless, Curry Cut is a perfect choice for preparing delicious, flavour-packed curries. Carefully sourced and processed, this skinless cut ensures a leaner, healthier option while retaining the natural tenderness and juiciness of chicken. Antibiotic-residue-free and free from growth hormones, it guarantees top-quality freshness. '),
(3, 2, 'cabbage', 26.00, 26.00, 'cabbage', 'cabbage.png', 45, '2026-02-04 14:40:14', 'Cabbage, known as \"Patta Gobi\" in Hindi, is a versatile vegetable integral to Indian cuisine. It is used in a variety of dishes across different regions, showcasing its adaptability and popularity. In North India, cabbage is often shredded and cooked with spices to make \"Patta Gobi Ki Sabzi,\" a flavourful side dish served with roti or rice. '),
(4, 4, 'milk - Amul Gold', 65.00, 65.00, 'milk', 'amulmilk.png', 140, '2026-02-04 14:40:14', 'Milk is a versatile dairy product widely used in cooking, baking, and beverages. Commonly enjoyed on its own or added to tea, coffee, cereals, and smoothies, milk is a staple in many households.'),
(5, 3, 'salmon fish', 345.00, 350.00, 'fish', 'salmonfish.png', 45, '2026-02-04 14:44:51', 'Big Sams is a well-known international brand which offers a range of quality frozen seafood. The raw salmon fillets provided by Big Sams is trimmed and cut into a fillets portion so that it is easy to cook. . They are hygienically processed under strict conditions, so that the fish reaches your home in its fresh best.'),
(6, 2, 'potato', 20.00, 25.00, 'potato', 'potato.png', 12, '2026-02-05 18:02:25', 'fresho! Potatoes offer a taste of pure, earthy goodness. Each spud is hand-picked for its perfect texture and flavour, ideal for crispy roasties or creamy mash. Packed with nutrients and versatility, they transform every meal into a wholesome delight. Enjoy the freshness and quality that only fresho! can provide.'),
(7, 2, 'tomato', 30.00, 30.00, 'tomato', 'tomato.png', 12, '2026-02-05 18:03:36', 'In the vibrant tapestry of Indian cuisine, local tomatoes play a pivotal role. Grown across diverse regions, these plump, juicy gems bring a burst of tangy flavour to countless dishes, from spicy curries to refreshing salads. '),
(8, 2, 'capsicum', 67.50, 69.00, 'capsicum', 'capsicum.png', 40, '2026-02-05 18:04:52', 'Green capsicum, known as bell pepper, is a versatile vegetable widely used in Indian cuisine. Its crisp texture and mild, slightly bitter flavour make it a favourite in curries, stir-fries, and salads across the country. In dishes like Paneer Tikka or Mixed Vegetable Sabzi, diced capsicum adds colour and enhances the overall taste. '),
(9, 2, 'yellow capsicum', 112.50, 120.00, 'capsicum', 'capsicumYellow.png', 23, '2026-02-07 14:38:19', 'Yellow capsicum, also known as yellow bell pepper, is a sweet and colourful vegetable prized for its mild flavour and crunchy texture. This versatile ingredient adds vibrant colour and a subtle sweetness to a variety of dishes, including salads, stir-fries, and roasted vegetables.'),
(65, 2, 'Potato - Sweet potato', 69.12, 91.00, 'potato', 'sweetpotato.png', 18, '2026-02-21 22:36:41', 'The size of crop will depend on how much sun, warmth and moisture the plants receive, and the length of the growing season – most varieties need at least four to five months.'),
(66, 2, 'Carrot - Orange', 79.00, 79.00, 'carrot', 'carrotorange.png', 25, '2026-02-21 22:43:06', 'While these greens are fresh-tasting and slightly bitter, the carrot roots are crunchy textured with a sweet and minty aromatic taste. Fresho! brings you the flavour and richness of the finest crispy and juicy carrots that are locally grown and the best of the region.\r\n\r\nIn the vibrant tapestry of Indian cuisine, orange carrots play a versatile role, prized for their sweetness and vibrant hue. Whether grated into salads, blended into creamy soups, or incorporated into decadent desserts like gajar ka halwa,');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(1) NOT NULL,
  `review_text` text NOT NULL,
  `review_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `product_id`, `user_id`, `rating`, `review_text`, `review_date`) VALUES
(1, 1, 1, 3, 'thik thak ache.. recommended', '2026-02-17 20:10:30'),
(3, 6, 12, 4, 'xx', '2026-02-17 20:25:03'),
(4, 2, 1, 3, 'not bad, could have been better price..', '2026-02-17 21:20:18');

-- --------------------------------------------------------

--
-- Table structure for table `userbase`
--

CREATE TABLE `userbase` (
  `user_id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(7) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userbase`
--

INSERT INTO `userbase` (`user_id`, `username`, `email`, `phone`, `user_password`, `created_date`, `status`) VALUES
(1, 'robot', 'pemere6581@bitonc.com', '1234567890', '$2y$10$qKnlBpynKg6szzSk300HKOCnogjYjbiw95..v3WMUDaqbyN4dmJMK', '2026-02-12 18:54:23', 'active'),
(2, 'billu', 'billu@email.com', '1212121212', '$2y$10$oZDkY8s45GIcD2xhNJAowOZc/5IZet1mRllWgChVtklclRaDX32QW', '2026-02-12 19:56:45', 'active'),
(3, 'monu', 'monu@email.com', '3434343434', '$2y$10$Xgk7tsIPjJb9v4PVT.5B2OUzhZglTe57OxPs/UxhpFz28Zx9y2OdS', '2026-02-12 20:49:06', 'active'),
(5, 'okla', 'okla@email.com', '4545454545', '$2y$10$/X5HeWepj4yIDClESKwWXeYi3MYQGUfB03YpOa1M2lK7epel3qj2i', '2026-02-12 22:53:26', 'active'),
(9, 'xxxx', 'xxxx@email.com', '9898989898', '$2y$10$V4CPzC95hP95Xm8X6qKJKOsto3Y0U.3i/j/unAGu.Vs4pPQENGObu', '2026-02-13 00:09:57', 'active'),
(10, 'ccc', 'ccc@email.com', '4040404040', '$2y$10$tF4sIi0nuVLZLi9HGPpKKOp/XAyIb9C33epXEQDE/l.hIIDmrGUMi', '2026-02-13 00:11:59', 'active'),
(11, 'mm', 'mm@email.com', '9109090910', '$2y$10$N7TugIdVr3bZrXAixbFOxOudv5pIrwADxMkgkPJPhsxBDakpmrHSS', '2026-02-13 00:24:24', 'active'),
(12, 'bali', 'billubiraj@gmail.com', '7834343434', '$2y$10$5TcVHnSnS0emB2iPflBfCOSlzFYtDI3bWdEH4jJVr9ngKqYk4pdmG', '2026-02-14 00:22:32', 'active'),
(13, 'test', 'test@test.com', '1010101010', '$2y$10$dy0Ou.mSudkYJ.ru.OJAX.Er.V/MGhszln2fhYoe9TQ0T4WbpzUs.', '2026-02-25 14:25:03', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `locality` varchar(255) DEFAULT NULL,
  `address_line1` text NOT NULL,
  `state` varchar(30) NOT NULL,
  `address_type` enum('Home','Work','Other') NOT NULL DEFAULT 'Home',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`id`, `user_id`, `name`, `phone`, `pincode`, `locality`, `address_line1`, `state`, `address_type`, `created_at`) VALUES
(1, 1, 'Rahul Roy', '9876543210', '700091', 'Near City Centre 2', 'Flat 4B, Green Heights, New Town', 'West Bengal', 'Home', '2026-02-13 20:51:43'),
(3, 1, 'Sumit Das', '8877665544', '733029', 'Near Kali Mandir', 'Vill - Rajivpur, PO - Raiganj, Dist - U/D', 'West Bengal', 'Other', '2026-02-13 20:51:43'),
(4, 12, 'bali Raj', '0912345690', '555555', 'near smart point', 'Banapur, Kirat.', 'Other', 'Other', '2026-02-14 00:56:43'),
(5, 12, 'bali Raj', '6767674532', '789531', 'near big market', 'address 2, no where', 'Other', 'Home', '2026-02-14 00:58:36'),
(6, 11, 'mm test', '4646123400', '666666', 'mm locality', 'mm address', 'West Bengal', 'Work', '2026-02-14 01:20:57'),
(7, 11, 'Mina Murmu', '8212121234', '333333', 'Bir para', 'bir para, xxxx', 'Other', 'Home', '2026-02-14 18:40:48'),
(8, 3, 'monu singh', '1267238910', '123212', 'monu locality', 'xxxxxxxxxxx', 'West Bengal', 'Home', '2026-02-17 21:18:46'),
(9, 13, 'test account', '1010101010', '781234', 'test colony', 'test address', 'West Bengal', 'Home', '2026-02-25 14:26:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detailsproduct`
--
ALTER TABLE `detailsproduct`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `message_customer`
--
ALTER TABLE `message_customer`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `userbase`
--
ALTER TABLE `userbase`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `detailsproduct`
--
ALTER TABLE `detailsproduct`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `message_customer`
--
ALTER TABLE `message_customer`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `userbase`
--
ALTER TABLE `userbase`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `userbase` (`user_id`);

--
-- Constraints for table `detailsproduct`
--
ALTER TABLE `detailsproduct`
  ADD CONSTRAINT `detailsproduct_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
