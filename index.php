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
    <link rel="stylesheet" href="styles.css">
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
                <tbody id="scheduleBody">
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
                    <input type="hidden" id="appointmentDate" name="appointment_date">
                    <input type="hidden" id="startTime" name="start_time">
                    <input type="hidden" id="endTime" name="end_time">
                    <input type="hidden" id="vetId" name="vet_id">
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

        async function fetchPets() {
            const response = await fetch('get_pets.php');
            const data = await response.json().catch(() => ({success:false}));
            if (data.success) {
                registeredPets = data.pets;
            }
        }

        async function fetchSchedule() {
            const response = await fetch('get_available_times.php');
            const data = await response.json().catch(() => ({success:false}));
            if (data.success) {
                const body = document.getElementById('scheduleBody');
                body.innerHTML = '';
                data.times.forEach(slot => {
                    const timeRange = formatTime(slot.start_time) + ' - ' + formatTime(slot.end_time);
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${slot.day}</td>
                        <td>${timeRange}</td>
                        <td>${slot.vet}</td>
                        <td><span class="badge badge-available">Available</span></td>
                        <td><button class="btn" onclick="showBookingModal('${slot.day}', '${timeRange}', '${slot.vet}', ${slot.vet_id}, '${slot.start_time}', '${slot.end_time}')">Book Now</button></td>
                    `;
                    body.appendChild(tr);
                });
            }
        }

        function formatTime(timeStr) {
            const [h, m] = timeStr.split(':');
            let hour = parseInt(h, 10);
            const suffix = hour >= 12 ? 'PM' : 'AM';
            hour = hour % 12 || 12;
            return `${hour}:${m} ${suffix}`;
        }

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
        function getNextDateForDay(day) {
            const days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
            const today = new Date();
            const target = days.indexOf(day);
            if (target === -1) return '';
            let diff = (target - today.getDay() + 7) % 7;
            if (diff === 0) diff = 7;
            const d = new Date(today);
            d.setDate(today.getDate() + diff);
            return d.toISOString().split('T')[0];
        }

        function showBookingModal(day, timeRange, vet, vetId, start, end) {
            document.getElementById('modalDateTime').textContent = `${day}, ${timeRange}`;
            document.getElementById('modalVet').textContent = vet;
            document.getElementById('appointmentDate').value = getNextDateForDay(day);
            document.getElementById('startTime').value = start;
            document.getElementById('endTime').value = end;
            document.getElementById('vetId').value = vetId;

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
                        form.reset();
                        alert('Pet registered successfully.');
                        fetchPets();
                    } else {
                        alert('Error registering pet.');
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert('Error registering pet.');
                });

        });

        document.getElementById('appointmentForm').addEventListener('submit', async function (event) {
            event.preventDefault();

            const petId = document.getElementById('appointmentPet').value;
            const pet = registeredPets.find(p => p.id === petId);

            if (!pet) {
                alert('Please select a valid pet.');
                return;
            }

            const formData = new FormData(this);
            formData.append('pet_id', petId);
            formData.append('type_id', 1);

            const response = await fetch('book_appointment.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json().catch(() => ({success:false}));
            if (data.success) {
                const appointment = {
                    id: data.id,
                    petId: petId,
                    date: document.getElementById('appointmentDate').value,
                    time: document.getElementById('startTime').value + ' - ' + document.getElementById('endTime').value,
                    vet: document.getElementById('modalVet').textContent,
                    reason: document.getElementById('appointmentReason').value,
                    notes: document.getElementById('appointmentNotes').value,
                    bookingDate: new Date().toLocaleDateString()
                };
                appointments.push(appointment);
                closeModal();
                alert(`Appointment booked successfully for ${pet.name}!`);
                showAppointments();
                fetchSchedule();
            } else {
                alert('Error booking appointment.');
            }
        });

        // Initialize data and show home section
        fetchPets();
        fetchSchedule();
        showHome();
    </script>
</body>

</html>