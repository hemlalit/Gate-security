# 🚪 Gate Security Web Application

An end-to-end **Gate Entry Management System** built to streamline and secure the entry process for **parents**, **visitors**, and **vendors** at an educational campus.  
Developed as a robust web-based solution, this system brings efficiency, automation, and accountability to campus access control.

<br/>

## 🔍 Project Overview

This application allows external visitors to:
- Register based on their visitor type (Parent, Visitor, Vendor)
- Verify contact details via OTP
- Schedule appointments with college staff/faculty
- Get access QR codes via email for gate entry
- Be tracked throughout their campus visit lifecycle (entry, meeting, exit)

Meanwhile, college staff and security personnel can:
- View, manage, and verify appointments
- Track and log entry/exit times
- Generate secure temporary passes using QR codes
- Ensure campus security by validating users with system-generated passes

<br/>

## 🛠️ Tech Stack

### 👨‍💻 Frontend
- **HTML**, **CSS**, **JavaScript**
- **jQuery** and **AJAX** for dynamic content and seamless user experience

### 🧠 Backend
- **PHP** (server-side scripting)
- **MySQL** (relational database for account & appointment data)
- **PHPMailer** (for sending OTPs and QR code passes via email)
- **phpqrcode** (for QR code pass generation)

<br/>

## 📌 Key Features

- 🔐 OTP-based phone number verification
- 👥 Role-based registration (Parent, Visitor, Vendor)
- 🗓️ Appointment scheduling with meeting tracking
- 🧾 Unique usernames auto-generated with system logic
- 📤 Email integration for QR code-based gate passes
- 🕓 Real-time entry, meeting, and exit logs
- 🛡️ Staff/faculty control over visitor permissions and pass expiration
- 🧾 Pass content includes: name, visit purpose, entry validity time, and verified authority

<br/>

## 🔁 Workflow Summary

1. **Registration**: 
   - Visitor selects type → fills form → verifies OTP → receives username → sets password.

2. **Login & Appointment**:
   - User logs in → fills appointment purpose → meeting scheduled with generated `meeting_id`.

3. **At the Gate**:
   - Security verifies visitor using `username` or `meeting_id` + ID proof.
   - Entry time is logged. Staff are notified of the visitor’s arrival.

4. **During Meeting**:
   - Faculty verifies visitor again → conducts meeting → ends meeting → logs end time.

5. **Exit & Pass Handling**:
   - Exit time is recorded.
   - For vendors/visitors: a pass is generated and emailed with time-bound validity.

6. **Security Checks**:
   - Any staff/security can ask for pass; failure to present results in action.

<br/>

## 🧠 What I Learned

- Applied **AJAX and jQuery** to make the site highly dynamic and user-friendly.
- Integrated **PHPMailer** for sending structured, templated emails with attachments (QR codes).
- Gained solid understanding of **user verification, authentication, and secure access systems**.
- Built and managed complex **relational database schemas** in **MySQL**.
- Learned **modular and secure PHP scripting** and how to manage file uploads, sessions, and logic separation.
- Understood real-world **access control workflows** and improved my logic-building and security mindset.

<br/>

## 📸 System Snapshot

- Role-based registration interface  
- Email-based OTP verification  
- QR code pass email for campus entry  
- Security and faculty dashboards for appointment control  
- Entry/exit timestamp tracking  
- Auto-expiring passes for visitors and vendors


<br/>

## 💡 Why This Project Stands Out

- Combines web development with **real-world security use case**
- Demonstrates full-stack capabilities with **dynamic frontend + secured backend**
- Implements **role-based control** and **real-time interaction**
- Highlights critical topics like **email automation, pass generation, and gate security protocol**

<br/>

# ✅ Smart, Secure, and Scalable — Just the Way Campus Security Should Be!




