    <?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetCare Pro - Professional Pet Care Services</title>
    <style>
        :root {
            --primary-color: #4e8cff;
            --secondary-color: #ff7e4e;
            --dark-color: #333;
            --light-color: #f4f4f4;
            --success-color: #28a745;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            line-height: 1.6;
            color: var(--dark-color);
            background-color: #f9f9f9;
        }
        
        header {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
        }
        
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .nav-links {
            display: flex;
            list-style: none;
        }
        
        .nav-links li {
            margin-left: 30px;
        }
        
        .nav-links a {
            text-decoration: none;
            color: var(--dark-color);
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .nav-links a:hover {
            color: var(--primary-color);
        }
        
        .btn {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        
        .btn:hover {
            background-color: #3a7be0;
        }
        
        .btn-secondary {
            background-color: var(--secondary-color);
        }
        
        .btn-secondary:hover {
            background-color: #e06d3a;
        }
        
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('pet-hero.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
            padding: 100px 0;
        }
        
        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }
        
        .hero p {
            font-size: 20px;
            max-width: 700px;
            margin: 0 auto 30px;
        }
        
        section {
            padding: 80px 0;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .section-title h2 {
            font-size: 36px;
            color: var(--primary-color);
            margin-bottom: 15px;
        }
        
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .service-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        
        .service-card:hover {
            transform: translateY(-10px);
        }
        
        .service-img {
            height: 200px;
            background-color: #ddd;
            background-size: cover;
            background-position: center;
        }
        
        .service-content {
            padding: 20px;
        }
        
        .service-content h3 {
            margin-bottom: 15px;
            color: var(--primary-color);
        }
        
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        
        .form-row {
            display: flex;
            gap: 20px;
        }
        
        .form-row .form-group {
            flex: 1;
        }
        
        .footer {
            background-color: var(--dark-color);
            color: white;
            padding: 50px 0 20px;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .footer-column h3 {
            color: var(--primary-color);
            margin-bottom: 20px;
            font-size: 20px;
        }
        
        .footer-column p, .footer-column a {
            color: #bbb;
            margin-bottom: 10px;
            display: block;
            text-decoration: none;
        }
        
        .footer-column a:hover {
            color: white;
        }
        
        .social-links {
            display: flex;
            gap: 15px;
        }
        
        .social-links a {
            color: white;
            font-size: 20px;
        }
        
        .copyright {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #444;
            color: #bbb;
        }
        
        /* Modal styles */
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
            padding: 30px;
            border-radius: 10px;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .close-modal {
            font-size: 24px;
            cursor: pointer;
        }
        
        /* Responsive styles */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            
            .hero h1 {
                font-size: 36px;
            }
            
            .hero p {
                font-size: 18px;
            }
            
            .form-row {
                flex-direction: column;
                gap: 0;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <a href="#" class="logo">PetCare Pro</a>
                <ul class="nav-links">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#book-appointment">Book Appointment</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="#" class="btn" id="login-btn">Login</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="hero" id="home">
        <div class="container">
            <h1>Professional Care for Your Beloved Pets</h1>
            <p>At PetCare Pro, we provide top-quality veterinary services to ensure your pets live happy and healthy lives.</p>
            <a href="#book-appointment" class="btn btn-secondary">Book an Appointment</a>
        </div>
    </section>
    <!-- Add this inside your dashboard.php where appropriate -->
<section id="register-pet">
    <div class="container">
        <div class="section-title">
            <h2>Register New Pet</h2>
        </div>
        <div class="form-container">
            <form action="register_pet.php" method="POST">
                <!-- User Information -->
                <div class="form-group">
                    <h3>Owner Information</h3>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" id="full_name" name="full_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" class="form-control" required>
                </div>

                <!-- Pet Information -->
                <div class="form-group">
                    <h3>Pet Details</h3>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="pet_name">Pet Name</label>
                        <input type="text" id="pet_name" name="pet_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="pet_type">Pet Type</label>
                        <select id="pet_type" name="pet_type" class="form-control" required>
                            <option value="">Select Type</option>
                            <option value="dog">Dog</option>
                            <option value="cat">Cat</option>
                            <option value="bird">Bird</option>
                            <option value="rabbit">Rabbit</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="breed">Breed</label>
                        <input type="text" id="breed" name="breed" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" id="age" name="age" class="form-control" min="0" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" class="form-control" required>
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <button type="submit" name="register_pet" class="btn">Register Pet</button>
            </form>
        </div>
    </div>
</section>

    <section id="services">
        <div class="container">
            <div class="section-title">
                <h2>Our Services</h2>
                <p>Comprehensive care for all your pet's needs</p>
            </div>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-img" style="background-image: url('grooming.jpg');"></div>
                    <div class="service-content">
                        <h3>Grooming</h3>
                        <p>Professional grooming services to keep your pet looking and feeling their best.</p>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-img" style="background-image: url('checkup.jpg');"></div>
                    <div class="service-content">
                        <h3>Health Checkups</h3>
                        <p>Regular examinations to monitor your pet's health and catch issues early.</p>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-img" style="background-image: url('surgery.jpg');"></div>
                    <div class="service-content">
                        <h3>Surgical Services</h3>
                        <p>Expert surgical care for your pet with the latest techniques and equipment.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="book-appointment">
        <div class="container">
            <div class="section-title">
                <h2>Book an Appointment</h2>
                <p>Schedule a visit with our expert veterinarians</p>
            </div>
            <div class="form-container">
                <form id="appointment-form">
                    <div class="form-group">
                        <h3>Your Information</h3>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="full-name">Full Name</label>
                            <input type="text" id="full-name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="existing-user">Existing User?</label>
                            <select id="existing-user" class="form-control">
                                <option value="no">No, I'm a new client</option>
                                <option value="yes">Yes, I have an account</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <h3>Pet Information</h3>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="pet-name">Pet Name</label>
                            <input type="text" id="pet-name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="pet-type">Pet Type</label>
                            <select id="pet-type" class="form-control" required>
                                <option value="">Select Pet Type</option>
                                <option value="dog">Dog</option>
                                <option value="cat">Cat</option>
                                <option value="bird">Bird</option>
                                <option value="rabbit">Rabbit</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="breed">Breed</label>
                            <select id="breed" class="form-control" required disabled>
                                <option value="">Select Breed</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pet-age">Age</label>
                            <input type="number" id="pet-age" class="form-control" min="0" max="30" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="pet-gender">Gender</label>
                            <select id="pet-gender" class="form-control" required>
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="appointment-type">Appointment Type</label>
                            <select id="appointment-type" class="form-control" required>
                                <option value="">Select Appointment Type</option>
                                <option value="grooming">Grooming</option>
                                <option value="checkup">Routine Checkup</option>
                                <option value="vaccination">Vaccination</option>
                                <option value="dental">Dental Care</option>
                                <option value="surgery">Surgery</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <h3>Appointment Details</h3>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="appointment-date">Preferred Date</label>
                            <input type="date" id="appointment-date" class="form-control" required min="">
                        </div>
                        <div class="form-group">
                            <label for="vet">Preferred Veterinarian</label>
                            <select id="vet" class="form-control" required>
                                <option value="">Any Available Veterinarian</option>
                                <option value="1">Dr. Sarah Johnson (Small Animals)</option>
                                <option value="2">Dr. Michael Chen (Surgery)</option>
                                <option value="3">Dr. Emily Wilson (Dentistry)</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="time-slots">Available Time Slots</label>
                        <div id="time-slots" class="time-slots-container">
                            <!-- Time slots will be dynamically generated here -->
                            <p>Please select a date and veterinarian to see available time slots.</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="notes">Additional Notes</label>
                        <textarea id="notes" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn">Book Appointment</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section id="about">
        <div class="container">
            <div class="section-title">
                <h2>About PetCare Pro</h2>
            </div>
            <div class="about-content">
                <p>PetCare Pro was founded in 2010 with a mission to provide exceptional veterinary care to pets in our community. Our team of experienced veterinarians and support staff are dedicated to ensuring the health and happiness of your furry family members.</p>
                <p>We believe in a compassionate approach to pet care, combining the latest medical technology with personalized attention for each patient. Our state-of-the-art facility is equipped to handle everything from routine checkups to complex surgical procedures.</p>
                <p>At PetCare Pro, we treat every pet as if they were our own, and we're committed to building lasting relationships with both our patients and their owners.</p>
            </div>
        </div>
    </section>

    <section id="contact">
        <div class="container">
            <div class="section-title">
                <h2>Contact Us</h2>
                <p>We're here to answer your questions</p>
            </div>
            <div class="form-container">
                <div class="form-row">
                    <div class="form-group">
                        <h3>Visit Us</h3>
                        <p>123 Pet Care Avenue<br>Animal City, AC 12345</p>
                    </div>
                    <div class="form-group">
                        <h3>Call Us</h3>
                        <p>Main Office: (555) 123-4567<br>Emergency: (555) 987-6543</p>
                    </div>
                    <div class="form-group">
                        <h3>Email Us</h3>
                        <p>info@petcarepro.com<br>appointments@petcarepro.com</p>
                    </div>
                </div>
                <div class="form-group">
                    <h3>Hours of Operation</h3>
                    <p>Monday - Friday: 8:00 AM - 6:00 PM<br>Saturday: 9:00 AM - 3:00 PM<br>Sunday: Emergency Only</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>PetCare Pro</h3>
                    <p>Providing exceptional veterinary care since 2010. Your pet's health is our top priority.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <a href="#home">Home</a>
                    <a href="#services">Services</a>
                    <a href="#book-appointment">Book Appointment</a>
                    <a href="#about">About Us</a>
                    <a href="#contact">Contact</a>
                </div>
                <div class="footer-column">
                    <h3>Services</h3>
                    <a href="#">Grooming</a>
                    <a href="#">Health Checkups</a>
                    <a href="#">Vaccinations</a>
                    <a href="#">Dental Care</a>
                    <a href="#">Surgical Services</a>
                </div>
                <div class="footer-column">
                    <h3>Contact Info</h3>
                    <p>123 Pet Care Avenue</p>
                    <p>Animal City, AC 12345</p>
                    <p>(555) 123-4567</p>
                    <p>info@petcarepro.com</p>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2023 PetCare Pro. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Login Modal -->
    <div class="modal" id="login-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Login to Your Account</h3>
                <span class="close-modal">&times;</span>
            </div>
            <form id="login-form">
                <div class="form-group">
                    <label for="login-email">Email</label>
                    <input type="email" id="login-email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="login-password">Password</label>
                    <input type="password" id="login-password" class="form-control" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn">Login</button>
                </div>
                <p>Don't have an account? <a href="#" id="register-link">Register here</a></p>
            </form>
        </div>
    </div>

    <script>
        // Sample JavaScript for the website functionality
        
        // Set minimum date for appointment (today + 1 day)
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);
            const minDate = tomorrow.toISOString().split('T')[0];
            document.getElementById('appointment-date').min = minDate;
            
            // Breed options based on pet type
            const petTypeSelect = document.getElementById('pet-type');
            const breedSelect = document.getElementById('breed');
            
            const breedOptions = {
                dog: ['Labrador Retriever', 'German Shepherd', 'Golden Retriever', 'Bulldog', 'Beagle'],
                cat: ['Persian', 'Siamese', 'Maine Coon', 'Ragdoll', 'Bengal'],
                bird: ['Parakeet', 'Cockatiel', 'African Grey', 'Canary', 'Cockatoo'],
                rabbit: ['Holland Lop', 'Mini Rex', 'Netherland Dwarf', 'Lionhead', 'Flemish Giant'],
                other: ['Other']
            };
            
            petTypeSelect.addEventListener('change', function() {
                const selectedType = this.value;
                breedSelect.innerHTML = '<option value="">Select Breed</option>';
                
                if (selectedType) {
                    breedSelect.disabled = false;
                    breedOptions[selectedType].forEach(breed => {
                        const option = document.createElement('option');
                        option.value = breed.toLowerCase().replace(' ', '-');
                        option.textContent = breed;
                        breedSelect.appendChild(option);
                    });
                } else {
                    breedSelect.disabled = true;
                }
            });
            
            // Modal functionality
            const loginBtn = document.getElementById('login-btn');
            const loginModal = document.getElementById('login-modal');
            const closeModal = document.querySelector('.close-modal');
            
            loginBtn.addEventListener('click', function(e) {
                e.preventDefault();
                loginModal.style.display = 'flex';
            });
            
            closeModal.addEventListener('click', function() {
                loginModal.style.display = 'none';
            });
            
            window.addEventListener('click', function(e) {
                if (e.target === loginModal) {
                    loginModal.style.display = 'none';
                }
            });
            
            // Form submission
            document.getElementById('appointment-form').addEventListener('submit', function(e) {
                e.preventDefault();
                alert('Appointment booked successfully! We will contact you shortly to confirm.');
                this.reset();
            });
            
            // Simulate time slot availability
            document.getElementById('appointment-date').addEventListener('change', function() {
                const timeSlotsContainer = document.getElementById('time-slots');
                timeSlotsContainer.innerHTML = '';
                
                if (this.value) {
                    const slots = ['09:00 AM', '10:30 AM', '12:00 PM', '02:00 PM', '03:30 PM', '05:00 PM'];
                    
                    slots.forEach(slot => {
                        const slotBtn = document.createElement('button');
                        slotBtn.type = 'button';
                        slotBtn.className = 'btn time-slot';
                        slotBtn.textContent = slot;
                        slotBtn.addEventListener('click', function() {
                            document.querySelectorAll('.time-slot').forEach(btn => {
                                btn.classList.remove('active');
                            });
                            this.classList.add('active');
                        });
                        timeSlotsContainer.appendChild(slotBtn);
                    });
                }
            });
        });
    </script>
</body>
</html>