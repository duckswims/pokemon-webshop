# Changelog

## Table of Contents
- [Ongoing Bugs](#ongoing-bugs)
- [Exercise-Sheet-5 (Final Tasks)](#exercise-sheet-5-final-tasks)
- [Exercise-Sheet-4 (PHP Preparations and JSON)](#exercise-sheet-4-php-preparations-and-json)
- [Exercise-Sheet-3 (JavaScript)](#exercise-sheet-3-javascript)
- [Exercise-Sheet-2 (CSS)](#exercise-sheet-2-css)
- [Exercise-Sheet-1 (HTML)](#exercise-sheet-1-html)


## Ongoing Bugs
- **Discount System:** Issue in applying the correct discount percentage or amount when a voucher code is used.
- **Coupon Management:** Displayed coupon code changes incorrectly when an action is performed on one of the coupons.


## Exercise-Sheet-5 (Final Tasks)
- **Shopping Cart**
    - Added a dynamic shopping cart icon showing the quantity of items in the cart.
    - Cart page lists selected products with options to adjust quantities or remove items.
    - Prices dynamically update based on cart modifications.
    - Logged-in users can access personalized carts to make purchases, while guests can use a temporary cart.
    - Orders are added to the user’s order history upon checkout.
- **Managing Orders**
    - *For Customers*
        - Customers can view the status of their orders.
        - Orders can be canceled if they have not been shipped.
    - *For Admins*
        - Order management interface for users and orders created.
        - Admins can update the order status and provide reasons for cancellations.
        - Ability to block users (blocked users cannot place orders).
- **Discounts**
    - Users receive a 10% discount for every 10th purchase and a 20% discount for every 20th purchase.
    - Voucher codes allow further discounts (bug in applying correct percentage or amount).
- **Extra Functionalities**
    - Products and orders are searchable by their IDs.
    - Products can be filtered by type.
    - Users can add and update billing and shipping addresses.
    - Admins can validate or invalidate coupon codes (bug in display changes for coupons).
    - Guest shopping carts are transferred to registered accounts upon login.
    - Pokémon type emojis are displayed at random positions when the corresponding type is clicked.
- **Bug Fixes**
    - Added a hamburger menu for mobile users (fix for Exercise-Sheet-3 Style Modification).
    - Fixed product additions to the collection list (fix for Exercise-Sheet-3 Collection List).
    - Corrected product display and `pid` query handling in `product.php` (fix for Exercise-Sheet-4 Category and Product Page).
    - Fixed the randomized product page redirection (feature from Exercise-Sheet-3) to work with the updated `product.php` and its product ID query.
- **Updates**
    - Standardized CSS classes.
    - Deprecated collection list in favor of the shopping cart feature.


## Exercise-Sheet-4 (PHP Preparations and JSON)
- Prepared the environment using XAMPP and Apache server.
- Migrated all `.html` files to `.php`.
- Created a JSON file (`product.json`) for the product list.
- Implemented `product.php` to load product details dynamically using `$_GET` requests (bug in loading `pid1` and `pid2` queries).


## Exercise-Sheet-3 (JavaScript)
- Enhanced form validation and visualization:
    - Usernames must have at least 5 characters, with one uppercase and one lowercase letter.
    - Passwords must be at least 10 characters long, and the confirmation password must match.
- Added **Dark Mode** and layout switching between horizontal and vertical formats.
- Created a collection list for products added to the cart (bug in counting the quantity; suspected due to the use of iframe).
- Dynamically calculated prices with and without tax.
- Added currency conversion functionality (extra feature).
- Enabled random redirection to a product page featuring a random Pokémon (extra feature).


## Exercise-Sheet-2 (CSS)
- Defined initial styles based on the task sheet.
- Designed styles for form fields.
- Established a consistent corporate identity.


## Exercise-Sheet-1 (HTML)
- Created the following HTML files:
    - `index.html`: Welcome homepage.
    - `login.html`: Login page for customer access.
    - `registration.html`: Registration page to create new accounts.
    - `logout.html`: Logout page for customers.
    - `customer.html`: Main profile page for customers.
    - `about.html`: Seller information page.
    - `<categoryName>List.html`: Product category pages.
    - `<product_id>.html`: Product detail pages.
    - `shoppingCart.html`: Page for selected items awaiting purchase.
