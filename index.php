<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetCare Pro - Veterinary Appointment System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Enhanced CSS with modern design */
        :root {
            --primary-color: #4a6fa5;
            --secondary-color: #166088;
            --accent-color: #4fc3a1;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f7fa;
        }

        /* Header with Navigation */
        header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .logo {
            display: flex;
            align-items: center;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .logo i {
            margin-right: 0.5rem;
            color: var(--accent-color);
        }

        nav ul {
            display: flex;
            list-style: none;
        }

        nav ul li {
            margin-left: 1.5rem;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 0;
            position: relative;
            transition: all 0.3s ease;
        }

        nav ul li a:hover {
            color: var(--accent-color);
        }

        nav ul li a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background: var(--accent-color);
            bottom: 0;
            left: 0;
            transition: width 0.3s ease;
        }

        nav ul li a:hover::after {
            width: 100%;
        }

        /* Main container styling */
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(74, 111, 165, 0.8), rgba(22, 96, 136, 0.8)), url('https://images.unsplash.com/photo-1534361960057-19889db9621e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 5rem 2rem;
            text-align: center;
            border-radius: 10px;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .hero p {
            font-size: 1.2rem;
            max-width: 800px;
            margin: 0 auto 2rem;
        }

        .btn {
            display: inline-block;
            background-color: var(--accent-color);
            color: white;
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn:hover {
            background-color: #3daa8a;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

        .btn-outline {
            background-color: transparent;
            border: 2px solid white;
            margin-left: 1rem;
        }

        .btn-outline:hover {
            background-color: white;
            color: var(--secondary-color);
        }

        /* Sections */
        .section {
            background-color: white;
            border-radius: 10px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .section h2 {
            color: var(--secondary-color);
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--accent-color);
        }

        /* Schedule Section */
        .schedule-section {
            display: none;
        }

        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.5rem;
        }

        .schedule-table th,
        .schedule-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .schedule-table th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
        }

        .schedule-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .schedule-table tr:hover {
            background-color: #f1f3f5;
        }

        .badge {
            display: inline-block;
            padding: 0.3rem 0.6rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-available {
            background-color: #d4edda;
            color: var(--success-color);
        }

        .badge-booked {
            background-color: #fff3cd;
            color: var(--warning-color);
        }

        /* Registration Form */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark-color);
        }

        .form-control {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(79, 195, 161, 0.2);
        }

        .form-row {
            display: flex;
            gap: 1.5rem;
        }

        .form-row .form-group {
            flex: 1;
        }

        /* Pet Cards */
        .pet-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .pet-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .pet-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .pet-card-header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pet-card-body {
            padding: 1.5rem;
        }

        .pet-card-body p {
            margin-bottom: 0.8rem;
        }

        .pet-card-footer {
            padding: 1rem;
            background-color: #f8f9fa;
            display: flex;
            justify-content: flex-end;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
            padding: 2rem;
            position: relative;
            animation: modalFadeIn 0.3s ease;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .close-modal {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 1.5rem;
            cursor: pointer;
            color: #777;
        }

        .close-modal:hover {
            color: var(--danger-color);
        }

        /* Footer */
        footer {
            background-color: var(--dark-color);
            color: white;
            padding: 3rem 0;
            margin-top: 3rem;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .footer-col h3 {
            color: var(--accent-color);
            margin-bottom: 1.5rem;
            font-size: 1.2rem;
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col ul li {
            margin-bottom: 0.8rem;
        }

        .footer-col ul li a {
            color: #ddd;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-col ul li a:hover {
            color: var(--accent-color);
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-links a {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background-color: var(--accent-color);
            transform: translateY(-3px);
        }

        .copyright {
            text-align: center;
            padding-top: 2rem;
            margin-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #aaa;
            font-size: 0.9rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-container {
                flex-direction: column;
                padding: 1rem;
            }

            nav ul {
                margin-top: 1rem;
            }

            nav ul li {
                margin-left: 1rem;
                margin-right: 1rem;
            }

            .hero {
                padding: 3rem 1rem;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .btn {
                display: block;
                width: 100%;
                margin-bottom: 1rem;
            }

            .btn-outline {
                margin-left: 0;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }

        .delay-1 {
            animation-delay: 0.1s;
        }

        .delay-2 {
            animation-delay: 0.2s;
        }

        .delay-3 {
            animation-delay: 0.3s;
        }
    </style>
</head>

<body>
    <!-- Header with Navigation -->
    <header>
        <div class="nav-container">
            <div class="logo">
                <i class="fas fa-paw"></i>
                <span>PetCare Pro</span>
            </div>
            <nav>
                <ul>
                    <li><a href="#" class="active" onclick="showHome()">Home</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="#" onclick="showSchedule()">Schedule</a></li>
                        <li><a href="#" onclick="showRegistration()">Register Pet</a></li>
                        <li><a href="#" onclick="showAppointments()">My Appointments</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="register.php">Register</a></li>
                        <li><a href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <!-- Hero Section -->
        <section class="hero fade-in">
            <h1>Premium Care for Your Beloved Pets</h1>
            <p>Schedule appointments with certified veterinarians and ensure your pet's health with our comprehensive
                care services. We treat your pets like family.</p>
            <a href="#" class="btn" onclick="showRegistration()">Register Your Pet</a>
            <a href="#" class="btn btn-outline" onclick="showSchedule()">View Schedule</a>
        </section>

        <!-- Home Section -->
        <section class="home-section section fade-in delay-1">
            <h2>Why Choose PetCare Pro?</h2>
            <div class="pet-cards">
                <div class="pet-card">
                    <div class="pet-card-header">
                        <h3><i class="fas fa-shield-alt"></i> Preventive Care</h3>
                    </div>
                    <div class="pet-card-body">
                        <p>Regular check-ups and vaccinations to keep your pet healthy and prevent diseases before they
                            start.</p>
                    </div>
                </div>
                <div class="pet-card">
                    <div class="pet-card-header">
                        <h3><i class="fas fa-stethoscope"></i> Expert Veterinarians</h3>
                    </div>
                    <div class="pet-card-body">
                        <p>Our team of certified veterinarians provides the highest quality care for all types of pets.
                        </p>
                    </div>
                </div>
                <div class="pet-card">
                    <div class="pet-card-header">
                        <h3><i class="fas fa-calendar-check"></i> Easy Scheduling</h3>
                    </div>
                    <div class="pet-card-body">
                        <p>Book appointments online at your convenience with our simple and intuitive scheduling system.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Schedule Section -->
        <section class="schedule-section section">
            <h2>Available Veterinary Schedule</h2>
            <p>Check the available times to book an appointment with our veterinarians:</p>
            <table class="schedule-table">
                <thead>
                    <tr>
                        <th>Day</th>
                        <th>Available Time</th>
                        <th>Veterinarian</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Monday</td>
                        <td>10:00 AM - 12:00 PM</td>
                        <td>Dr. Sarah Johnson</td>
                        <td><span class="badge badge-available">Available</span></td>
                        <td><button class="btn"
                                onclick="showBookingModal('Monday', '10:00 AM - 12:00 PM', 'Dr. Sarah Johnson')">Book
                                Now</button></td>
                    </tr>
                    <tr>
                        <td>Tuesday</td>
                        <td>2:00 PM - 4:00 PM</td>
                        <td>Dr. Michael Chen</td>
                        <td><span class="badge badge-available">Available</span></td>
                        <td><button class="btn"
                                onclick="showBookingModal('Tuesday', '2:00 PM - 4:00 PM', 'Dr. Michael Chen')">Book
                                Now</button></td>
                    </tr>
                    <tr>
                        <td>Wednesday</td>
                        <td>10:00 AM - 12:00 PM</td>
                        <td>Dr. Emily Wilson</td>
                        <td><span class="badge badge-booked">Limited</span></td>
                        <td><button class="btn"
                                onclick="showBookingModal('Wednesday', '10:00 AM - 12:00 PM', 'Dr. Emily Wilson')">Book
                                Now</button></td>
                    </tr>
                    <tr>
                        <td>Friday</td>
                        <td>1:00 PM - 3:00 PM</td>
                        <td>Dr. Robert Garcia</td>
                        <td><span class="badge badge-available">Available</span></td>
                        <td><button class="btn"
                                onclick="showBookingModal('Friday', '1:00 PM - 3:00 PM', 'Dr. Robert Garcia')">Book
                                Now</button></td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Registration Section -->
        <section class="registration-section section">
        <?php if (isset($_SESSION['user_id'])): ?>
            <h2>Register Your Pet</h2>
            <form id="registrationForm">
                <div class="form-row">
                    <div class="form-group">
                        <label for="ownerPhone">Phone Number</label>
                        <input type="tel" id="ownerPhone" name="ownerPhone" class="form-control"
                            placeholder="(123) 456-7890" required>
                    </div>
                    <div class="form-group">
                        <label for="petName">Pet's Name</label>
                        <input type="text" id="petName" name="petName" class="form-control" placeholder="Buddy"
                            required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="petType">Pet Type</label>
                        <select id="petType" name="petType" class="form-control" required>
                            <option value="">Select pet type</option>
                            <option value="Dog">Dog</option>
                            <option value="Cat">Cat</option>
                            <option value="Bird">Bird</option>
                            <option value="Rabbit">Rabbit</option>
                            <option value="Reptile">Reptile</option>
                            <option value="Small Mammal">Small Mammal</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="petBreed">Breed</label>
                        <input type="text" id="petBreed" name="petBreed" class="form-control"
                            placeholder="Golden Retriever">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="petAge">Age (years)</label>
                        <input type="number" id="petAge" name="petAge" class="form-control" placeholder="3" min="0"
                            max="30">
                    </div>
                    <div class="form-group">
                        <label for="petGender">Gender</label>
                        <select id="petGender" name="petGender" class="form-control" required>
                            <option value="">Select gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="petNotes">Special Notes</label>
                    <textarea id="petNotes" name="petNotes" class="form-control" rows="3"
                        placeholder="Any medical conditions, allergies, or special requirements"></textarea>
                </div>

                <button type="submit" class="btn">Register Pet</button>
            </form>
        <?php else: ?>
            <p>Please <a href="login.php">login</a> to register your pet.</p>
        <?php endif; ?>
        </section>

        <!-- Appointments Section -->
        <section class="appointments-section section" style="display: none;">
            <h2>My Appointments</h2>
            <div id="appointmentsList">
                <p>No appointments scheduled yet. <a href="#" onclick="showSchedule()">Book an appointment now!</a></p>
            </div>
        </section>
    </div>

    <!-- Booking Modal -->
    <div class="modal" id="bookingModal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal()">&times;</span>
            <h2>Book Appointment</h2>
            <form id="appointmentForm">
                <div class="form-group">
                    <label>Date & Time</label>
                    <p id="modalDateTime" style="font-weight: bold; margin-bottom: 1rem;"></p>
                </div>

                <div class="form-group">
                    <label>Veterinarian</label>
                    <p id="modalVet" style="font-weight: bold; margin-bottom: 1rem;"></p>
                </div>

                <div class="form-group">
                    <label for="appointmentPet">Select Pet</label>
                    <select id="appointmentPet" name="appointmentPet" class="form-control" required>
                        <option value="">Select a registered pet</option>
                        <!-- Will be populated by JavaScript -->
                    </select>
                </div>

                <div class="form-group">
                    <label for="appointmentReason">Reason for Visit</label>
                    <select id="appointmentReason" name="appointmentReason" class="form-control" required>
                        <option value="">Select reason</option>
                        <option value="Annual Checkup">Annual Checkup</option>
                        <option value="Vaccination">Vaccination</option>
                        <option value="Illness">Illness</option>
                        <option value="Injury">Injury</option>
                        <option value="Dental Care">Dental Care</option>
                        <option value="Grooming">Grooming</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="appointmentNotes">Additional Notes</label>
                    <textarea id="appointmentNotes" name="appointmentNotes" class="form-control" rows="3"
                        placeholder="Any specific concerns or details"></textarea>
                </div>

                <button type="submit" class="btn">Confirm Appointment</button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-col">
                <h3>PetCare Pro</h3>
                <p>Providing exceptional veterinary care for your beloved pets since 2010. Your pet's health is our top
                    priority.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#" onclick="showHome()">Home</a></li>
                    <li><a href="#" onclick="showSchedule()">Schedule</a></li>
                    <li><a href="#" onclick="showRegistration()">Register Pet</a></li>
                    <li><a href="#" onclick="showAppointments()">My Appointments</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>Services</h3>
                <ul>
                    <li><a href="#">Preventive Care</a></li>
                    <li><a href="#">Emergency Services</a></li>
                    <li><a href="#">Dental Care</a></li>
                    <li><a href="#">Surgical Procedures</a></li>
                    <li><a href="#">Grooming</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>Contact Us</h3>
                <ul>
                    <li><i class="fas fa-map-marker-alt"></i> 123 PetCare St, City</li>
                    <li><i class="fas fa-phone"></i> (123) 456-7890</li>
                    <li><i class="fas fa-envelope"></i> info@petcarepro.com</li>
                    <li><i class="fas fa-clock"></i> Mon-Fri: 9AM-6PM</li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2023 PetCare Pro. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Global variables to store registered pets and appointments
        let registeredPets = [];
        let appointments = [];

        // Show different sections
        function showHome() {
            document.querySelector('.home-section').style.display = 'block';
            document.querySelector('.schedule-section').style.display = 'none';
            document.querySelector('.registration-section').style.display = 'none';
            document.querySelector('.appointments-section').style.display = 'none';

            // Update active nav link
            updateActiveNav('home');
        }

        function showSchedule() {
            document.querySelector('.home-section').style.display = 'none';
            document.querySelector('.schedule-section').style.display = 'block';
            document.querySelector('.registration-section').style.display = 'none';
            document.querySelector('.appointments-section').style.display = 'none';

            // Update active nav link
            updateActiveNav('schedule');
        }

        function showRegistration() {
            document.querySelector('.home-section').style.display = 'none';
            document.querySelector('.schedule-section').style.display = 'none';
            document.querySelector('.registration-section').style.display = 'block';
            document.querySelector('.appointments-section').style.display = 'none';

            // Update active nav link
            updateActiveNav('register');
        }

        function showAppointments() {
            document.querySelector('.home-section').style.display = 'none';
            document.querySelector('.schedule-section').style.display = 'none';
            document.querySelector('.registration-section').style.display = 'none';
            document.querySelector('.appointments-section').style.display = 'block';

            // Update active nav link
            updateActiveNav('appointments');

            // Display appointments if any exist
            displayAppointments();
        }

        function updateActiveNav(section) {
            const navLinks = document.querySelectorAll('nav ul li a');
            navLinks.forEach(link => link.classList.remove('active'));

            if (section === 'home') {
                document.querySelector('nav ul li:first-child a').classList.add('active');
            } else if (section === 'schedule') {
                document.querySelector('nav ul li:nth-child(2) a').classList.add('active');
            } else if (section === 'register') {
                document.querySelector('nav ul li:nth-child(3) a').classList.add('active');
            } else if (section === 'appointments') {
                document.querySelector('nav ul li:nth-child(4) a').classList.add('active');
            }
        }

        // Modal functions
        function showBookingModal(day, time, vet) {
            document.getElementById('modalDateTime').textContent = `${day}, ${time}`;
            document.getElementById('modalVet').textContent = vet;

            // Populate pets dropdown
            const petSelect = document.getElementById('appointmentPet');
            petSelect.innerHTML = '<option value="">Select a registered pet</option>';

            if (registeredPets.length === 0) {
                const option = document.createElement('option');
                option.value = '';
                option.textContent = 'No pets registered. Please register a pet first.';
                option.disabled = true;
                petSelect.appendChild(option);
            } else {
                registeredPets.forEach(pet => {
                    const option = document.createElement('option');
                    option.value = pet.id;
                    option.textContent = `${pet.name} (${pet.type})`;
                    petSelect.appendChild(option);
                });
            }

            document.getElementById('bookingModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('bookingModal').style.display = 'none';
            document.getElementById('appointmentForm').reset();
        }

        // Display appointments
        function displayAppointments() {
            const appointmentsList = document.getElementById('appointmentsList');

            if (appointments.length === 0) {
                appointmentsList.innerHTML = '<p>No appointments scheduled yet. <a href="#" onclick="showSchedule()">Book an appointment now!</a></p>';
                return;
            }

            let html = '<div class="pet-cards">';

            appointments.forEach(appointment => {
                const pet = registeredPets.find(p => p.id === appointment.petId);

                html += `
                    <div class="pet-card">
                        <div class="pet-card-header">
                            <h3><i class="fas fa-calendar-alt"></i> ${appointment.date}</h3>
                        </div>
                        <div class="pet-card-body">
                            <p><strong>Time:</strong> ${appointment.time}</p>
                            <p><strong>Veterinarian:</strong> ${appointment.vet}</p>
                            <p><strong>Pet:</strong> ${pet ? pet.name : 'Unknown'} (${pet ? pet.type : 'Unknown'})</p>
                            <p><strong>Reason:</strong> ${appointment.reason}</p>
                            ${appointment.notes ? `<p><strong>Notes:</strong> ${appointment.notes}</p>` : ''}
                        </div>
                        <div class="pet-card-footer">
                            <button class="btn" style="background-color: var(--danger-color);" onclick="cancelAppointment('${appointment.id}')">Cancel</button>
                        </div>
                    </div>
                `;
            });

            html += '</div>';
            appointmentsList.innerHTML = html;
        }

        function cancelAppointment(appointmentId) {
            if (confirm('Are you sure you want to cancel this appointment?')) {
                appointments = appointments.filter(app => app.id !== appointmentId);
                displayAppointments();
                alert('Appointment cancelled successfully.');
            }
        }

        // Form submission handlers
        document.getElementById('registrationForm').addEventListener('submit', function (event) {
            event.preventDefault();

            const form = this;
            const formData = new FormData(form);

            fetch('register_pet.php', {
                method: 'POST',
                body: formData
            })
                .then(async (response) => {
                    const text = await response.text();

                    try {
                        const data = JSON.parse(text);
                        return data;
                    } catch (e) {
                        throw new Error('Response is not valid JSON');
                    }
                })
                .then(data => {
                    if (data.success) {
                        // Your existing pet registration logic
                    } else {
                        alert('Error registering pet.');
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert('Error registering pet.');
                });

        });

        document.getElementById('appointmentForm').addEventListener('submit', function (event) {
            event.preventDefault();

            const petId = document.getElementById('appointmentPet').value;
            const pet = registeredPets.find(p => p.id === petId);

            if (!pet) {
                alert('Please select a valid pet.');
                return;
            }

            // Create appointment object
            const appointment = {
                id: Date.now().toString(),
                petId: petId,
                date: document.getElementById('modalDateTime').textContent.split(',')[0],
                time: document.getElementById('modalDateTime').textContent.split(',')[1].trim(),
                vet: document.getElementById('modalVet').textContent,
                reason: document.getElementById('appointmentReason').value,
                notes: document.getElementById('appointmentNotes').value,
                bookingDate: new Date().toLocaleDateString()
            };

            // Add to appointments
            appointments.push(appointment);

            // Close modal and reset form
            closeModal();

            // Show success message
            alert(`Appointment booked successfully for ${pet.name}!`);

            // Show appointments
            showAppointments();
        });

        // Initialize by showing home section
        showHome();
    </script>
</body>

</html>