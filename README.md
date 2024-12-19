<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://github.com/Thomas-Emad/eLumos/blob/main/public/assets/images/logo.png?raw=true" width="400" alt="Laravel Logo"></a></p>

### **eLumos - Educational Platform**

eLumos is a modern educational platform connecting instructors and students, providing powerful tools for creating and managing courses, lessons, and exams. Recent updates and features include:

### **New Features**

1.  **Certificate Generation:**
    
    *   After completing a course, students can download a personalized certificate.
        
    *   Certificates can be shared directly with friends and social networks.
        
2.  **Purchase Tracking and Invoicing:**
    
    *   Users can track all purchase transactions in their accounts.
        
    *   Downloadable invoices for each purchase.
        
3.  **Enhanced Admin Dashboard:**
    
    *   Admins can change course statuses easily.
        
    *   A detailed review history log is available for tracking course updates and decisions.
        

### **Core Features**

#### **1\. Course and Lesson Management**

*   Courses can include sections with lessons in text, video, or quiz formats.
    

#### **2\. Exam Creation and Reports**

*   Dynamic exam creation with automatic grading.
    
*   Comprehensive reports detailing mistakes, grades, and overall performance.
    

#### **3\. Secure Video Hosting**

*   Videos managed securely with **Cloudinary API**.
    

#### **4\. Role Management**

*   Platform owners can create roles for students, instructors, and admins.
    

#### **5\. Admin Review System**

*   Courses require admin approval to meet platform standards.
    

#### **6\. Payment Integration**

*   Supports **Stripe** and **PayPal**.
    
*   Webhooks for secure and reliable transactions.
    
*   A wallet system to manage funds for students and instructors.
    

#### **7\. Advanced Search and Recommendations**

*   Advanced filtering for courses.
    
*   Personalized recommendations based on preferences.
* * * * *
### **Installation**

Follow these steps to set up eLumos on your local environment:

1.  **Clone the Repository:**
    ```
    git clone https://github.com/yourusername/elumos.git
    cd elumos
    ```

2.  **Install Dependencies:**\
    Ensure **PHP**, **Composer**, and **Node.js** are installed, then run:
    ```
    composer install
    npm install && npm run dev
    ```

4.  **Set Up the Environment File:**\
    Copy the `.env.example` file to `.env` and configure it:
    ```
    cp .env.example .env
    php artisan key:generate
    ```

5.  **Configure Database:**\
    Update database credentials in the `.env` file, then migrate and seed:
    ```
    php artisan migrate --seed
    ```

6.  **Start the Server:**
    ```
    php artisan serve
    ```

8.  **Environment Variables for External Services:**\
    Add the following keys to your `.env` file for external service integration:
    ```
    CLOUDINARY_URL=
    CLOUDINARY_UPLOAD_PRESET=

    STRIPE_KEY=
    STRIPE_SECRET=
    STRIPE_WEBHOOK_SECRET=

    PAYPAL_KEY=
    PAYPAL_SECRET=
    PAYPAL_BASE_URL=
    ```

* * * * *
### **Roles and Permissions**

#### **1\. Students:**

*   Browse and enroll in courses.
    
*   Manage wallets, purchases, and certificates.
    

#### **2\. Instructors:**

*   Create and update courses.
    
*   Monitor student progress.
    

#### **3\. Admins:**

*   Oversee platform activity.
    
*   Manage users, review courses, and monitor logs.
* * * * * 

### **Usage Highlights**

*   Certificates upon course completion.
    
*   Secure payment handling.
    
*   Detailed purchase history and invoicing.
    
*   A streamlined admin interface with enhanced features.
    
* * * * *
