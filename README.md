# 🔨 Online Auction System

Welcome to the **Online Auction System**, a highly concurrent, fully procedural MVC PHP web application built for **Web Technologies CSE 4101**.

This platform provides a secure environment for competitive, real-time e-commerce auctions. It separates the platform into four distinct, highly secure role-based modules, ensuring strict access control and separation of concerns.

---

## 👥 Meet the Team

This project was developed collaboratively by four students from the **American International University-Bangladesh (AIUB)**, Department of Computer Science.

| Team Member | Role Module | Description |
| :--- | :--- | :--- |
| **Mohaimenuul Haque** | 🛒 **Buyer** | Engineered the consumer experience, including real-time AJAX bidding, dynamic watchlist tracking, and post-transaction seller reviews. |
| **Abrar Tajwar Adib** | 🏪 **Seller** | Developed the supply-side tools, including multi-image listing creation, live AJAX bid polling, and high-level revenue analytics. |
| **Samia Jannat Liza** | 🛡️ **Moderator** | Built the Trust & Safety system, featuring a fast-action AJAX listing approval queue and user dispute resolution workflows. |
| **Md Sohag Islam** | 👑 **Administrator** | Designed the executive dashboard, tracking global financial commissions, managing user access, and verifying seller identities. |

---

## 🚀 Core Features

### 🛒 Buyer Features
*   **Real-Time AJAX Bidding:** Place competitive bids dynamically without reloading the window.
*   **Intelligent Notifications:** The dashboard instantly alerts buyers if they have won an item or have been outbid on an active auction.
*   **Watchlists:** Keep track of interesting items before committing to a bid.

### 🏪 Seller Features
*   **Live Bid Polling:** An asynchronous JavaScript loop allows sellers to watch intense bidding wars unfold on their active items in real-time.
*   **SQL Analytics Engine:** Native database queries calculate total revenue and average sale prices instantly.
*   **Multi-Image Uploads:** Secure `multipart/form-data` processing allowing up to 5 images per listing.

### 🛡️ Moderator Features
*   **AJAX Approval Queue:** An incredibly fast moderation workflow that uses DOM manipulation to instantly remove approved/rejected items from the reviewer's screen.
*   **Reporting & Warnings:** Allows moderation staff to respond to user complaints and issue formal warnings to rule-breaking sellers.

### 👑 Administrator Features
*   **Financial Tracking:** Dynamically calculates aggregate platform commission and daily bidding volume using advanced MySQL date functions.
*   **Instant Deactivation:** The Admin can securely ban or reactivate any user across the platform with a single click.
*   **Verification Gatekeeping:** Controls exactly who is allowed to sell items on the platform by reviewing ID document requests.

---

## 💻 Tech Stack

*   **Frontend:** HTML5, CSS3 (Grid/Flexbox Layouts)
*   **Client Scripting:** Vanilla JavaScript (`XMLHttpRequest` for AJAX functionality)
*   **Backend:** PHP (Procedural MVC Architecture)
*   **Database:** MySQL (Prepared Statements for SQL Injection protection)
*   **Authentication:** Native PHP Sessions (Role-Based Access Control)
*   **Environment:** XAMPP / Apache / Herd

---

## ⚙️ Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/Sohagsrz/online-auction-system.git
   ```
2. **Setup the Database:**
   * Create a new MySQL database (e.g., `oas_db`).
   * Import the provided `database/schema.sql` file.
   * Run the `database/seed.sql` file to populate the system with dummy users, categories, and items.
3. **Configure Environment:**
   * Open `database/db.php` and ensure the database credentials match your local MySQL configuration.
4. **Launch:**
   * Host the application via XAMPP, WAMP, or Laravel Herd, and navigate to the project root in your browser.

---
*Developed for AIUB Spring 2025–2026. Academic use only.*
