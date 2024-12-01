<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://github.com/Thomas-Emad/eLumos/blob/main/public/assets/images/logo.png?raw=true" width="400" alt="Laravel Logo"></a></p>

### **eLumos - Educational Platform**

eLumos is a modern educational platform that connects instructors with students, providing powerful tools to create and manage courses, lessons, and exams. The platform offers:

-   **Dynamic Exam Creation** with various question types and automatic grading.
-   **Course Structure** that allows instructors to organize content into sections and lessons.
-   **Role Management** for flexible access control by the platform owner.
-   **Admin Review System** ensuring courses comply with platform policies.
-   **Detailed Exam Reports** summarizing student performance with grades and mistakes.
-   **Secure Video Hosting** using **Cloudinary API** for automatic video management.
-   **Advanced Search** features to help students find courses with multiple filters.
-   **Integrated Payment Gateways** including Stripe and PayPal, with a robust **wallet system** for transactions.

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

### **Features**

#### **1\. Course and Lesson Management**

-   Courses can have multiple sections, and each section can include lessons in text, video, or quiz format.

#### **2\. Exam Creation and Reports**

-   Customize exams with time limits and various question types.
-   Automatic grading with a detailed report after submission, highlighting mistakes, scores, and feedback.

#### **3\. Secure Video Hosting**

-   Videos are uploaded and managed securely using **Cloudinary API**.

#### **4\. Role Management**

-   Owners can create and manage roles for students, instructors, and admins.

#### **5\. Admin Review System**

-   All submitted courses require admin approval to ensure compliance.

#### **6\. Payment Integration**

-   **Stripe** and **PayPal** for seamless payments.
-   **Webhook handling** ensures reliability during transactions.
-   A **wallet system** for students and instructors to manage course purchases.

#### **7\. Advanced Search and Recommendations**

-   Students can find courses easily using advanced filters.
-   Personalized course recommendations based on individual preferences.

* * * * *

### **Roles and Permissions**

1.  **Students:**

    -   Browse, enroll in courses, and complete exams.
    -   Manage wallets and payments.
2.  **Instructors:**

    -   Create, update, and manage courses and lessons.
    -   Monitor student progress and feedback.
3.  **Admins:**

    -   Oversee platform activity, manage users, and review courses.
    -   Generate reports and resolve issues.

* * * * *

### **Usage Highlights**

-   After completing an exam, students receive a **detailed performance report**.
-   Payments are handled securely with real-time issue management via webhooks.
-   The platform provides **intuitive navigation** for all users, ensuring a smooth experience.

* * * * *
