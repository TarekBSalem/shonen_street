# Testing Guide - Pre-Submission Checklist

## 🎯 Complete Testing Checklist for Recruiter Submission

### Prerequisites Setup

```bash
# 1. Fresh database setup
php artisan migrate:fresh --seed 

# 2. Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 3. Build frontend assets
npm run build

# 4. Start queue worker (REQUIRED - open in separate terminal)
php artisan queue:work

# 5. Verify storage link
php artisan storage:link
```

---

## 📋 Testing Workflow

### Phase 1: Admin Authentication & Setup ✅

**Test Admin Login:**

1. Go to: `http://shonen_street.test/admin/login`
2. Login with:
    - Email: `admin@shonenstreet.test`
    - Password: `password`
3. ✅ Should redirect to `/admin/dashboard`

**Expected Result:**

- Login successful
- Dashboard loads with sidebar navigation
- Logo displays correctly

---

### Phase 2: Product Management ✅

**Test Product CRUD:**

1. **View Products:**
    - Click "Products" in sidebar
    - ✅ Should see 10 seeded products with images
    - ✅ Images should load correctly

2. **Create Product:**
    - Click "Add Product" button
    - Fill in:
        - Name: "Test Manga Vol. 1"
        - Price: 12.99
        - Stock: 25
        - Upload an image (max 20MB)
    - Click "Save"
    - ✅ Product should appear in list with image preview

3. **Edit Product:**
    - Click edit icon on any product
    - Change name to "Updated Manga Vol. 1"
    - Change price to 14.99
    - Click "Save"
    - ✅ Changes should be reflected immediately

4. **Delete Product:**
    - Click delete icon on the test product
    - Confirm deletion
    - ✅ Product should be removed from list

**Common Issues to Check:**

- [ ] Images upload successfully (if not, check `.user.ini` and restart Herd)
- [ ] Image preview shows correctly
- [ ] Validation errors display properly
- [ ] Modal closes after successful save

---

### Phase 3: User Management ✅

**Test User CRUD:**

1. **View Users:**
    - Click "Users" in sidebar
    - ✅ Should see 20 seeded users (no admins shown)

2. **Create User:**
    - Click "Add User" button
    - Fill in:
        - Name: "Test User"
        - Email: "testuser@example.com"
        - Password: "password"
        - Confirm Password: "password"
    - Click "Save"
    - ✅ User should appear in list

3. **Edit User:**
    - Click edit icon on test user
    - Change name to "Updated Test User"
    - Leave password empty (no change)
    - Click "Save"
    - ✅ User info should update

4. **Delete User:**
    - Click delete icon on test user
    - Confirm deletion
    - ✅ User should be removed

**Common Issues to Check:**

- [ ] Email uniqueness validation works
- [ ] Password confirmation validation works
- [ ] Can update user without changing password
- [ ] Cannot delete admin users

---

### Phase 4: Client Registration & Login ✅

**Test Client Authentication:**

1. **Register New Client:**
    - Go to: `http://shonen_street.test/register`
    - Fill in:
        - Name: "John Doe"
        - Email: "john@example.com"
        - Password: "password"
        - Confirm Password: "password"
    - Click "Register"
    - ✅ Should redirect to `/shop`

2. **Logout:**
    - Click user icon in header
    - Click "Logout"
    - ✅ Should redirect to home page

3. **Login:**
    - Go to: `http://shonen_street.test/login`
    - Email: "john@example.com"
    - Password: "password"
    - Click "Login"
    - ✅ Should redirect to `/shop`

**Common Issues to Check:**

- [ ] Logo displays correctly on auth pages
- [ ] Validation errors show properly
- [ ] Cannot login with admin credentials here
- [ ] Redirects work correctly

---

### Phase 5: Shopping Experience ✅

**Test Shop Page:**

1. **Browse Products:**
    - Go to `/shop`
    - ✅ Should see all products with images
    - ✅ Hero section displays
    - ✅ Product count shows correctly

2. **Search Products:**
    - Type "Naruto" in search box
    - Click "Apply Filters"
    - ✅ Should show only Naruto products

3. **Filter by Price:**
    - Set Min: 9.00, Max: 10.00
    - Click "Apply Filters"
    - ✅ Should show products in that price range

4. **Sort Products:**
    - Select "Price: Low to High"
    - Click "Apply Filters"
    - ✅ Products should be sorted by price ascending

5. **Clear Filters:**
    - Click "Clear Filters"
    - ✅ Should show all products again

**Common Issues to Check:**

- [ ] Images load correctly
- [ ] Pagination works (if more than 12 products)
- [ ] Filters work independently and combined
- [ ] Stock indicators show correctly

---

### Phase 6: Shopping Cart ✅

**Test Cart Functionality:**

1. **Add to Cart:**
    - From shop page, click "Add to Cart" on 3 different products
    - ✅ Should see success toast messages
    - ✅ Cart icon badge should update (currently shows 0 - this is a known limitation)

2. **View Cart:**
    - Click cart icon or go to `/cart`
    - ✅ Should see all 3 products
    - ✅ Images display correctly
    - ✅ Prices show correctly
    - ✅ Subtotal, Shipping ($10), Total calculated correctly

3. **Update Quantity:**
    - Change quantity of first product to 3
    - Click update button
    - ✅ Quantity should update
    - ✅ Total should recalculate

4. **Remove Item:**
    - Click trash icon on one product
    - Confirm removal
    - ✅ Product should be removed
    - ✅ Total should recalculate

**Common Issues to Check:**

- [ ] Can't add more than available stock
- [ ] Calculations are accurate (no tax)
- [ ] Remove confirmation works
- [ ] Empty cart message shows when no items

---

### Phase 7: Checkout Process ✅

**Test Checkout:**

1. **Go to Checkout:**
    - From cart, click "Proceed to Checkout"
    - ✅ Should redirect to `/checkout`

2. **Verify Preloaded Data:**
    - ✅ Name should be preloaded with user's name
    - ✅ Email should be preloaded with user's email

3. **Fill Shipping Info:**
    - Phone: "+1 (555) 123-4567"
    - Address: "123 Main Street"
    - City: "New York"
    - State: "NY"
    - Zip: "10001"
    - Country: "United States"

4. **Review Order:**
    - ✅ Order items display correctly
    - ✅ Subtotal, Shipping, Total are correct
    - ✅ No payment card section (removed)

5. **Place Order:**
    - Click "Place Order"
    - ✅ Should redirect to order confirmation page
    - ✅ Order details display correctly

**Common Issues to Check:**

- [ ] Validation errors show for required fields
- [ ] Can't checkout with empty cart
- [ ] Stock is validated before order creation
- [ ] Order confirmation shows correct information

---

### Phase 8: Order Management (Admin) ✅

**Test Admin Order Management:**

1. **View Orders:**
    - Login as admin
    - Click "Orders" in sidebar
    - ✅ Should see the order just placed
    - ✅ Status shows as "pending"
    - ✅ Customer name and total display

2. **Filter Orders:**
    - Click "Processing" tab
    - ✅ Should show no orders
    - Click "All" tab
    - ✅ Should show all orders again

3. **Search Orders:**
    - Type customer name in search
    - ✅ Should filter orders

4. **View Order Details:**
    - Click "View" on an order
    - ✅ Should see full order details:
        - Order items with images
        - Shipping address
        - Customer information
        - Order summary

5. **Update Order Status:**
    - Select "Processing" from status dropdown
    - Click "Update Status"
    - ✅ Status should update
    - ✅ Success message should show

6. **Test Status Workflow:**
    - Update to "Shipped"
    - ✅ Should work
    - Update to "Delivered"
    - ✅ Should work
    - Try to update again
    - ✅ Should show error (can't change from delivered)

**Common Issues to Check:**

- [ ] Order items show correct prices
- [ ] Shipping address displays properly
- [ ] Status transitions work correctly
- [ ] Can't change from delivered/cancelled

---

### Phase 9: Email Notifications ✅

**IMPORTANT: Queue worker MUST be running!**

**Test Email Notifications:**

1. **Check Mailhog:**
    - Open: `http://localhost:8025`
    - ✅ Should see Mailhog interface

2. **Order Confirmation (Client):**
    - Place an order as client
    - Wait 5-10 seconds
    - Check Mailhog
    - ✅ Should receive "Order Confirmed" email
    - ✅ Email should include:
        - Order number
        - Order items
        - Total amount
        - Shipping address

3. **New Order (Admin):**
    - Check Mailhog
    - ✅ Should receive "New Order" email to admin
    - ✅ Email should include:
        - Order number
        - Customer name
        - Total amount
        - Link to order details

4. **Order Status Update (Client):**
    - As admin, update order status to "Shipped"
    - Wait 5-10 seconds
    - Check Mailhog
    - ✅ Should receive "Order Status Updated" email to client
    - ✅ Email should include:
        - Order number
        - Old status → New status
        - Status-specific message

5. **Low Stock Alert (Admin):**
    - As client, order products until one has < 10 stock
    - Wait 5-10 seconds
    - Check Mailhog
    - ✅ Should receive "Low Stock Alert" email to admin
    - ✅ Email should include:
        - Product name
        - Current stock quantity
        - Link to products page

6. **Password Reset:**
    - Logout
    - Go to forgot password
    - Enter email
    - Check Mailhog
    - ✅ Should receive password reset email
    - ✅ Email should include logo and reset link

**Common Issues to Check:**

- [ ] Queue worker is running (`php artisan queue:work`)
- [ ] Mailhog is accessible at localhost:8025
- [ ] All emails have proper branding (logo)
- [ ] Links in emails work correctly
- [ ] Failed jobs: `php artisan queue:failed` (should be empty)

---

### Phase 10: Daily Sales Report ✅

**Test Scheduled Command:**

1. **Manual Test:**

    ```bash
    php artisan sales:daily-report
    ```

2. **If Orders Exist Today:**
    - ✅ Should see "Generating daily sales report..."
    - ✅ Should see "Report sent to: admin@shonenstreet.test"
    - Check Mailhog
    - ✅ Should receive "Daily Sales Report" email
    - ✅ Email should include:
        - Date
        - Total orders
        - Total revenue
        - Products sold with quantities

3. **If No Orders Today:**
    - ✅ Should see "No sales today. Skipping report."

**Common Issues to Check:**

- [ ] Command runs without errors
- [ ] Email sends correctly
- [ ] Report data is accurate
- [ ] Scheduled in `routes/console.php` for 6 PM daily

---

## 🔍 Final Pre-Submission Checks

### Code Quality ✅

```bash
# Check for linter errors
npm run lint

# Check PHP syntax
php artisan route:list  # Should run without errors
```

### Database ✅

```bash
# Verify migrations
php artisan migrate:status

# All should show "Ran"
```

### Files & Permissions ✅

```bash
# Check storage link
ls -la public/storage  # Should point to storage/app/public

# Check image files exist
ls -la storage/app/public/products/  # Should show 5+ images

# Check writable directories
ls -la storage/logs/  # Should be writable
```

### Environment ✅

- [ ] `.env` file configured correctly
- [ ] `APP_URL` matches your local domain
- [ ] `DB_*` credentials correct
- [ ] `MAIL_*` configured for Mailhog
- [ ] `QUEUE_CONNECTION=database`

### Frontend ✅

```bash
# Build production assets
npm run build

# Check for build errors
# Should complete without errors
```

---

## 📦 Preparing for Submission

### 1. Clean Up

```bash
# Remove test data (optional - or leave seeded data)
php artisan migrate:fresh --seed --force

# Clear all caches
php artisan optimize:clear

# Remove node_modules (recruiter will install)
rm -rf node_modules

# Remove vendor (recruiter will install)
rm -rf vendor
```

### 2. Create `.env.example`

Make sure `.env.example` has all required variables:

```env
APP_NAME="Shonen Street"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shonen_street
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@shonenstreet.test"
MAIL_FROM_NAME="${APP_NAME}"

QUEUE_CONNECTION=database
```

### 3. Documentation Check

Ensure these files are complete and accurate:

- [ ] `README.md` - Complete setup instructions
- [ ] `SETUP.md` - Quick start guide
- [ ] `FEATURES.md` - Feature documentation
- [ ] `TESTING_GUIDE.md` - This file

### 4. Git Repository

```bash
# Check git status
git status

# Ensure these are in .gitignore:
# - node_modules/
# - vendor/
# - .env
# - storage/app/public/products/* (except .gitignore)
# - public/storage

# Commit final changes
git add .
git commit -m "Final production-ready version"
```

---

## 🎬 Demo Script for Recruiter

Create a quick demo video or follow this script:

### 1. Introduction (30 seconds)

"This is Shonen Street, an e-commerce platform for manga built with Laravel 10, Vue 3, and Inertia.js. It features separate admin and client interfaces, following SOLID principles."

### 2. Admin Demo (2 minutes)

- Login as admin
- Show product management (create, edit, delete)
- Show user management
- Show order management
- Update order status

### 3. Client Demo (2 minutes)

- Register new client
- Browse shop with filters
- Add products to cart
- Complete checkout
- Show order confirmation

### 4. Notifications Demo (1 minute)

- Show Mailhog with emails
- Explain queue system
- Show low stock notification
- Show daily sales report command

### 5. Code Quality (1 minute)

- Show clean architecture (Actions, Services)
- Show SOLID principles
- Show comprehensive documentation

---

## 🐛 Known Issues & Limitations

### Current Limitations:

1. **Cart Badge:** Shows "0" instead of actual cart count (frontend limitation)
    - Fix: Would need to pass cart count from backend to all pages
2. **Real-time Updates:** No WebSocket for real-time notifications
    - Current: Email + database notifications only
3. **Image Optimization:** Images not automatically resized/optimized
    - Current: Accepts up to 20MB, stores as-is

### Not Implemented (Out of Scope):

- Payment gateway integration
- Inventory history tracking
- Product reviews/ratings
- Wishlist functionality
- Advanced analytics dashboard
- Multi-language support

---

## ✅ Final Checklist Before Submission

### Technical:

- [ ] All migrations run successfully
- [ ] Seeders create test data
- [ ] Queue worker processes jobs
- [ ] Emails send correctly
- [ ] Images display properly
- [ ] No console errors in browser
- [ ] No PHP errors in logs
- [ ] Production build completes

### Functional:

- [ ] Admin can manage products
- [ ] Admin can manage users
- [ ] Admin can manage orders
- [ ] Clients can register/login
- [ ] Clients can browse products
- [ ] Clients can add to cart
- [ ] Clients can checkout
- [ ] Notifications send correctly
- [ ] Daily report works

### Documentation:

- [ ] README.md complete
- [ ] SETUP.md clear and concise
- [ ] FEATURES.md comprehensive
- [ ] TESTING_GUIDE.md (this file) complete
- [ ] Code comments where needed
- [ ] .env.example up to date

### Repository:

- [ ] All files committed
- [ ] .gitignore correct
- [ ] No sensitive data in repo
- [ ] Clean commit history
- [ ] Repository is public (if required)

---

## 🎯 Success Criteria

Your application is ready for submission when:

✅ You can complete all tests in this guide without errors
✅ All emails send correctly through Mailhog
✅ Images display on all pages
✅ No console or PHP errors
✅ Documentation is clear and complete
✅ Code follows SOLID principles
✅ Repository is clean and organized

---

## 📞 Support

If you encounter any issues during testing:

1. Check `storage/logs/laravel.log` for PHP errors
2. Check browser console for JavaScript errors
3. Check `php artisan queue:failed` for failed jobs
4. Restart queue worker: `php artisan queue:restart`
5. Clear caches: `php artisan optimize:clear`
6. Rebuild assets: `npm run build`

---

**Good luck with your submission! 🚀**

This application demonstrates:

- Clean architecture
- SOLID principles
- Modern tech stack
- Production-ready code
- Comprehensive documentation
- Professional development practices
