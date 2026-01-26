# 📦 Algerian Affiliate Platform (Laravel) — AI Agent Tasks

## 🎯 Goal
Build a **lead-based affiliate marketing platform** for the Algerian market using Laravel.

**Key Points:**
- **No online payments** — This is a lead generation system only
- Orders happen offline (phone, WhatsApp, in-person)
- Manual commission payouts by admin
- Referral-based tracking for affiliate attribution

---

## 🧱 Phase 0 — Assumptions & Constraints

- Laravel latest stable version
- SQLite database (development)
- **No payment gateway integration** (not a transaction platform)
- COD / Phone / WhatsApp orders only (offline)
- Admin validates commissions manually based on confirmed sales
- Filament and Spatie Permissions **already installed manually** (DO NOT install them)
- All tables use Laravel timestamps (created_at, updated_at)
- Use soft deletes where applicable (products, leads, commissions)

---

## 📦 Phase 1 — Required Packages (DO NOT INSTALL)

The project assumes the following packages are already installed or will be installed manually:

- `filament/filament` (v3.x)
- `spatie/laravel-permission`

**⚠️ The AI agent MUST NOT install these packages.**

---

## 🛠 Phase 2 — Project Setup

### Task 2.1
Create a fresh Laravel project structure (no install commands).

### Task 2.2
Configure `.env` placeholders:
```env
APP_NAME="Algerian Affiliate Platform"
APP_URL=http://localhost

DB_CONNECTION=sqlite
# DB_DATABASE=/absolute/path/to/database.sqlite

SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=database
```

### Task 2.3
Migration order (important for foreign keys):
1. users
2. roles & permissions (Spatie - already installed)
3. merchants
4. affiliates
5. products
6. affiliate_requests
7. leads
8. commissions
9. withdrawals

---

## 👤 Phase 3 — User Roles & Permissions

### Roles
- **admin** — Full platform control
- **merchant** — Manages products, approves leads
- **affiliate** — Promotes products, earns commissions

### Task 3.1
Create a `RoleSeeder`:
- Create 3 roles: admin, merchant, affiliate
- Use Spatie's `Role::create(['name' => 'admin'])`

### Task 3.2
Update `User` model:
- Use Spatie `HasRoles` trait
- Add helper methods:
  ```php
  public function isAdmin(): bool
  public function isMerchant(): bool
  public function isAffiliate(): bool
  ```

---

## 🏪 Phase 4 — Merchant Domain

### Task 4.1 — Merchant Profile
Create:
- `merchants` table migration
- `Merchant` model

Fields:
- `id` (primary key)
- `user_id` (foreign key, unique)
- `company_name` (string)
- `phone` (string)
- `whatsapp` (string, nullable)
- `approved_at` (timestamp, nullable)
- `timestamps`

### Task 4.2
Relationships:
- `User` hasOne `Merchant`
- `Merchant` belongsTo `User`

---

## 📦 Phase 5 — Products / Services

### Task 5.1
Create:
- `products` table migration
- `Product` model

Fields:
- `id` (primary key)
- `merchant_id` (foreign key)
- `title` (string)
- `description` (text, nullable)
- `commission_type` (enum: 'fixed', 'percent')
- `commission_value` (decimal 10,2)
- `is_active` (boolean, default true)
- `timestamps`
- `soft_deletes`

### Task 5.2
Create Filament Resource: `ProductResource`
- List products (merchant sees only their own)
- Create/Edit product form
- Toggle `is_active` status

Authorization:
- Merchant can only manage their own products
- Use policy: `ProductPolicy`

---

## 🤝 Phase 6 — Affiliate Domain

### Task 6.1
Create:
- `affiliates` table migration
- `Affiliate` model

Fields:
- `id` (primary key)
- `user_id` (foreign key, unique)
- `referral_code` (string, unique, indexed)
- `timestamps`

### Task 6.2
Auto-generate `referral_code` on creation:
- Format: 8 characters, alphanumeric, uppercase
- Ensure uniqueness with retry logic
- Example: `AFF12X7K`
- Use observer or model event: `creating`

### Task 6.3
Relationships:
- `User` hasOne `Affiliate`
- `Affiliate` belongsTo `User`

---

## 🔗 Phase 7 — Affiliate Requests (Join Merchant)

### Task 7.1
Create:
- `affiliate_requests` table migration
- `AffiliateRequest` model

Fields:
- `id` (primary key)
- `affiliate_id` (foreign key)
- `merchant_id` (foreign key)
- `status` (enum: 'pending', 'approved', 'rejected')
- `reviewed_at` (timestamp, nullable)
- `timestamps`
- Unique constraint: `[affiliate_id, merchant_id]`

### Task 7.2
Business logic:
- Affiliate requests to join/promote merchant's products
- Merchant approves or rejects via Filament
- Only approved requests enable referral tracking for that merchant's products
- Prevent duplicate requests

---

## 🧭 Phase 8 — Referral Tracking

### Task 8.1
Create middleware:
- `CaptureReferral`

Behavior:
- If `?ref=CODE` exists in URL:
  - Validate referral code exists in `affiliates` table
  - Store in session: `referral_code`
  - Store in cookie: `referral_code` (30 days, http only)
  - Optional: Log referral capture for analytics

### Task 8.2
Register middleware:
- Apply to `web` middleware group
- Or specific routes where referrals are captured

---

## 📞 Phase 9 — Leads System

### Task 9.1
Create:
- `leads` table migration
- `Lead` model

Fields:
- `id` (primary key)
- `product_id` (foreign key)
- `affiliate_id` (foreign key, nullable)
- `customer_name` (string)
- `phone` (string, indexed)
- `order_value` (decimal 10,2, nullable) — filled when merchant approves lead
- `source` (enum: 'call', 'whatsapp', 'form')
- `status` (enum: 'pending', 'approved', 'rejected', indexed)
- `notes` (text, nullable)
- `approved_at` (timestamp, nullable)
- `rejected_at` (timestamp, nullable)
- `timestamps`
- `soft_deletes`

### Task 9.2
Lead creation logic:
- Capture referral code from session/cookie
- Resolve `affiliate_id` from referral code
- **Validate:** Affiliate must be approved for this product's merchant
- **Anti-fraud:** Check duplicate phone within 24h for same product
- If valid, create lead with `status = 'pending'`
- If invalid referral, create lead without affiliate_id (direct lead)

### Task 9.3
Create Filament Resource: `LeadResource`
- Merchant views leads for their products only
- Approve/Reject actions
- When approving:
  - Merchant enters `order_value` (actual sale amount)
  - Set `status = 'approved'`, `approved_at = now()`
  - Trigger commission creation (Phase 10)

---

## 💰 Phase 10 — Commissions

### Task 10.1
Create:
- `commissions` table migration
- `Commission` model

Fields:
- `id` (primary key)
- `affiliate_id` (foreign key, indexed)
- `lead_id` (foreign key, unique)
- `product_id` (foreign key)
- `amount` (decimal 10,2)
- `status` (enum: 'pending', 'paid', indexed)
- `paid_at` (timestamp, nullable)
- `timestamps`

### Task 10.2
Commission calculation (triggered when lead approved):
- If `product.commission_type = 'fixed'`:
  - `amount = product.commission_value`
- If `product.commission_type = 'percent'`:
  - `amount = (lead.order_value × product.commission_value) / 100`
- Create commission record with `status = 'pending'`
- Use Laravel Observer: `LeadObserver@updated`

### Task 10.3
Relationships:
- `Commission` belongsTo `Affiliate`
- `Commission` belongsTo `Lead`
- `Commission` belongsTo `Product`

---

## 🧾 Phase 11 — Withdrawal Requests

### Task 11.1
Create:
- `withdrawals` table migration
- `Withdrawal` model

Fields:
- `id` (primary key)
- `affiliate_id` (foreign key, indexed)
- `amount` (decimal 10,2)
- `method` (enum: 'cash', 'ccp', 'baridimob', 'bank')
- `account_info` (text) — JSON or plain text with payment details
- `status` (enum: 'pending', 'approved', 'paid', 'rejected', indexed)
- `processed_at` (timestamp, nullable)
- `notes` (text, nullable) — admin notes
- `timestamps`

### Task 11.2
Business logic:
- Affiliate can request withdrawal if:
  - Total `commissions.status = 'pending'` >= minimum threshold (e.g., 5000 DZD)
- When withdrawal approved by admin:
  - Mark related commissions as `status = 'paid'`
  - Set `withdrawals.status = 'paid'`, `processed_at = now()`
- **Note:** This is a manual payout system (no automated transfers)

---

## 📧 Phase 11.5 — Notifications (Optional)

### Task 11.5.1
Setup notification events using Laravel Notifications:

**For Merchant:**
- New affiliate request received
- New lead received

**For Affiliate:**
- Affiliate request approved/rejected
- Lead approved → commission earned
- Withdrawal request processed

**For Admin:**
- New withdrawal request pending

Channels:
- Database notifications (in-app)
- Email (optional, via Filament)

---

## 🛡 Phase 12 — Authorization Rules

### Task 12.1
Create Laravel Policies:

**ProductPolicy:**
- Merchant can view/update/delete only own products

**LeadPolicy:**
- Merchant can view leads for own products only
- Merchant can approve/reject own leads
- Affiliate can view own leads only

**CommissionPolicy:**
- Affiliate can view own commissions
- Admin can view all

**WithdrawalPolicy:**
- Affiliate can create/view own withdrawals
- Admin can view/process all

### Task 12.2
Register policies in `AuthServiceProvider`

---

## 📊 Phase 13 — Dashboards

### Affiliate Dashboard (Filament Widgets)
- Total leads generated
- Approved leads count
- Pending commission amount (sum where status = 'pending')
- Paid commission amount (sum where status = 'paid')
- Available for withdrawal

### Merchant Dashboard (Filament Widgets)
- Products count (active)
- Incoming leads (pending)
- Approved leads (this month)
- Approved affiliates count

### Admin Dashboard (Filament Widgets)
- Total merchants (approved)
- Total affiliates
- Total commissions earned (all time)
- Pending withdrawals count + total amount

**Note:** Use Filament Widgets (StatsOverviewWidget) for dashboard stats

---

## 🚨 Phase 14 — Anti-Fraud Rules

### Task 14.1
Implement fraud detection when creating leads:

**Reject lead if:**
- Duplicate phone number within 24h for the same product
- Affiliate's own phone number is used (self-referral)
- Affiliate is not approved for this product's merchant
- Referral code is invalid or expired

**Optional enhancements:**
- Rate limiting: Max X leads per affiliate per day
- Suspicious IP detection
- Phone number validation (Algerian format)

### Task 14.2
Log fraud attempts:
- Create `fraud_logs` table (optional)
- Record rejected attempts for admin review

---

## 🧪 Phase 15 — Seeders & Testing

### Task 15.1
Create seeders:

**DatabaseSeeder:**
1. `RoleSeeder` — Create roles
2. `AdminSeeder` — Create admin user with admin role
3. `MerchantSeeder` — Create sample merchant + user
4. `AffiliateSeeder` — Create sample affiliate + user with referral code
5. `ProductSeeder` — Create sample products for merchant
6. `AffiliateRequestSeeder` — Create approved request between affiliate & merchant

### Task 15.2
Test scenarios:
- Affiliate generates referral link
- Lead submits via referral link
- Merchant approves lead
- Commission auto-created
- Affiliate requests withdrawal
- Admin processes withdrawal

---

## 🚀 Phase 16 — Database Optimization

### Task 16.1
Add indexes for performance:
- `affiliates.referral_code` (unique)
- `leads.phone` (for duplicate checking)
- `leads.status` (for filtering)
- `leads.product_id` (foreign key queries)
- `commissions.affiliate_id` (for aggregations)
- `commissions.status` (for filtering)
- `affiliate_requests.merchant_id, status` (for approvals)

---

## 📄 Phase 17 — Documentation

### Task 17.1
Create `README.md` with:

**Project Overview:**
- Algerian affiliate marketing platform
- Lead generation system (not e-commerce)
- No online payment processing

**How It Works:**
1. Merchants register and create products with commission rates
2. Affiliates request to promote merchant products
3. Merchants approve affiliate requests
4. Affiliates share referral links (`?ref=CODE`)
5. Customers click links and submit leads (phone/WhatsApp)
6. Merchants receive leads and contact customers offline
7. When sale confirmed, merchant approves lead + enters order value
8. System calculates commission automatically
9. Affiliates request withdrawals
10. Admin processes manual payouts (CCP, BaridiMob, cash, bank)

**Roles & Permissions:**
- Admin: Full access
- Merchant: Products, leads, affiliate approvals
- Affiliate: Lead tracking, commissions, withdrawals

**Algerian Market Assumptions:**
- No credit card payments
- COD and phone orders are standard
- Payment methods: CCP, BaridiMob, bank transfer, cash
- Manual commission payouts by admin

**Setup Instructions:**
- Installation steps
- Database migration
- Seeding test data
- Filament admin panel access

---

## ✅ End State

A Laravel backend that:
- ✅ Tracks referrals via unique affiliate codes
- ✅ Validates leads with anti-fraud rules
- ✅ Calculates commissions automatically (fixed or percentage)
- ✅ Supports manual withdrawal requests
- ✅ Admin processes payouts manually (no payment gateway)
- ✅ Filament admin panel ready
- ✅ Built for Algerian market (no online payments) 🇩🇿

---

## 🎯 Success Criteria

The platform is ready when:
1. A merchant can create products with commission rates
2. An affiliate can generate and share referral links
3. Leads are captured and attributed correctly
4. Commissions are calculated when leads are approved
5. Affiliates can request withdrawals
6. Admins can process withdrawals manually
7. All fraud prevention rules are enforced
8. Filament dashboards show relevant stats per role