﻿
<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>HospiBridge - Advanced Healthcare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/stylehome.css') }}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
</head>
<body>


@include('layouts.navigation')
    </nav></section> 
    <!-- Hero Section -->
    <section class="hero">
        <video class="hero-video" autoplay muted loop playsinline>
            <source src="{{ asset('videos/hero.mp4') }}" type="video/mp4">
        </video>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <span class="hero-badge">Trusted Care, Anytime</span>
            <h2 class="hero-title">Welcome to HospiBridge</h2>
            <p class="hero-subtitle">Advanced telemedicine, rapid crisis response, and personalized pathways for a safer, smarter healthcare experience.</p>
            <div class="hero-actions">
                <a href="{{ url('/register') }}" class="btn btn-primary hero-cta">Book Appointment</a>
                <a href="{{ url('/services') }}" class="btn btn-outline-light hero-cta">Explore Services</a>
            </div>
            <div class="hero-container">

        <div class="hero-card">
            <i class="fas fa-user-plus"></i>
            <h3>Create Your Account</h3>
            <p>Easily schedule your appointment online.</p>
            <a href="{{ url('/register') }}" class="btn btn-primary">Book an Appointment</a>
        </div>

        <div class="hero-card">
            <i class="fas fa-file-medical"></i>
            <h3>Access Your Account</h3>
            <p>Access your medical records anytime.</p>
            <a href="{{ url('/login') }}" class="btn btn-primary">Check your files</a>
        </div>

        <div class="hero-card">
            <i class="fas fa-headset"></i>
            <h3>Need Help?</h3>
            <p>Our team is here to answer your healthcare questions.</p>
            <a href="{{ url('/contactz') }}" class="btn btn-primary">Contact Us</a>
        </div>

    </div>

</div>
    </section>
    <!-- Services Section -->
    <section class="services">
        <div class="container">
            <h2>Our Services</h2>
            <p class="section-intro">A modern care network built for speed, security and patient-first outcomes across routine and emergency pathways.</p>
            <div id="servicesCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#servicesCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#servicesCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#servicesCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="service-slide">
                            <i class="fas fa-stethoscope"></i>
                            <h3>General Checkup</h3>
                            <p>Comprehensive health checkups to ensure your wellbeing with advanced diagnostic tools and personalized care plans.</p>
                            <a href="{{ url('/services') }}" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="service-slide">
                            <i class="fas fa-tooth"></i>
                            <h3>Dental Care</h3>
                            <p>Advanced dental treatments with expert doctors using state-of-the-art technology for healthy smiles.</p>
                            <a href="{{ url('/services') }}" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="service-slide">
                            <i class="fas fa-heartbeat"></i>
                            <h3>Cardiology</h3>
                            <p>Specialized care for heart and cardiovascular diseases with cutting-edge treatments and preventive care.</p>
                            <a href="{{ url('/services') }}" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#servicesCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#servicesCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>

    <section class="crisis-support">
        <div class="container">
            <div class="section-header">

                <h2>Guided Symptom Assessment</h2>
                <p>A quick 5-question check-in that points you to the right specialty and doctor.</p>
            </div>
            <div class="crisis-overview">
                <div class="crisis-text" data-aos="fade-right" data-aos-delay="100">
                    <h3>Step-by-Step Triage</h3>
                    <p>HospiBridge uses straightforward keyword matching and guided symptom prompts to help patients start with the most relevant department, then move quickly into booking or telemedicine follow-up.</p>
                    <div class="ai-features">
                        <div class="feature-item">
                            <i class="fas fa-chart-line"></i>
                            <span>Guided Check-In</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-user-md"></i>
                            <span>AI Specialist Matching</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-calendar-check"></i>
                            <span>Smart Scheduling</span>
                        </div>
                    </div>
                </div>
                <div class="crisis-panel" data-aos="fade-left" data-aos-delay="150">
                    <div class="crisis-panel-header">
                        <i class="fas fa-robot"></i>
                        Symptom Assistant
                        <span class="ai-status" id="aiStatus">Ready to help</span>
                    </div>
                    <div class="triage-chat" id="triageChat">
                        <div class="chat-line system welcome">
                            <span class="chat-speaker">AI Assistant</span>
                            <p>Hello! I'm here to help assess your symptoms. Please describe your main symptom or concern.</p>
                        </div>
                    </div>
                    <div class="chat-input-area">
                        <div class="input-group">
                            <input type="text" id="patientInput" class="form-control" placeholder="Type your response here..." disabled>
                            <button class="btn btn-send" id="sendButton" disabled>
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                        <div class="quick-responses" id="quickResponses">
                            <button class="quick-btn" data-response="Headache">Headache</button>
                            <button class="quick-btn" data-response="Chest pain">Chest pain</button>
                            <button class="quick-btn" data-response="Fever">Fever</button>
                            <button class="quick-btn" data-response="Cough">Cough</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="our-journey">
        <div class="container">
            <!-- Mission Box -->
            <div class="box mission-box" data-aos="fade-right" data-aos-duration="1200" data-aos-delay="100">
                <i class="fas fa-heartbeat"></i>
                <h3>Our Mission</h3>
                <p>To revolutionize healthcare delivery through AI-powered diagnostics, telemedicine excellence, and personalized treatment protocols that anticipate patient needs and optimize clinical outcomes in an era of medical innovation.</p>
            </div>

            <!-- Vision Box -->
            <div class="box vision-box" data-aos="fade-left" data-aos-duration="1200" data-aos-delay="200">
                <i class="fas fa-binoculars"></i>
                <h3>Our Vision</h3>
                <p>To establish a paradigm of predictive healthcare where artificial intelligence seamlessly integrates with human expertise, creating a global benchmark for intelligent, compassionate, and technologically advanced medical care.</p>
            </div>
        </div>
    </section>

    <section class="our-journey">
        <div class="container">
            <h2>Our Evolutionary Journey</h2>
            <div class="timeline">
                <!-- Step 1 -->
                <div class="timeline-step" data-aos="fade-up">
                    <div class="step-icon">�</div>
                    <div class="step-content">
                        <h3>Planning & Requirements</h3>
                        <p>Mapped the core healthcare flows, identified the main user roles, and defined the appointment, scheduling, and communication features for the platform.</p>
                    </div>
                </div>
                <!-- Step 2 -->
                <div class="timeline-step" data-aos="fade-up" data-aos-delay="150">
                    <div class="step-icon">🗓️</div>
                    <div class="step-content">
                        <h3>Booking System</h3>
                        <p>Built the appointment booking experience so patients can choose a doctor, select a time slot, and track the status of each request from one place.</p>
                    </div>
                </div>
                <!-- Step 3 -->
                <div class="timeline-step" data-aos="fade-up" data-aos-delay="300">
                    <div class="step-icon">📹</div>
                    <div class="step-content">
                        <h3>Telemedicine Integration</h3>
                        <p>Connected remote consultations with Zoom links and WhatsApp notifications so accepted appointments can move smoothly from intake to follow-up.</p>
                    </div>
                </div>
                <!-- Step 4 -->
                <div class="timeline-step" data-aos="fade-up" data-aos-delay="450">
                    <div class="step-icon">🛠️</div>
                    <div class="step-content">
                        <h3>Admin Panel</h3>
                        <p>Expanded the dashboard for administrators to manage doctors, schedules, messages, prescriptions, and patient requests with a single workflow.</p>
                    </div>
                </div>
                <!-- Step 5 -->
                <div class="timeline-step" data-aos="fade-up" data-aos-delay="600">
                    <div class="step-icon">🚀</div>
                    <div class="step-content">
                        <h3>Deployment & Support</h3>
                        <p>Prepared the platform for launch with environment configuration, production-ready settings, and ongoing improvements based on real clinic operations.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="health-ticker-separator">
        <section class="health-ticker-section">
            <div class="container">
                <h2 class="ticker-title">Advanced Health Intelligence</h2>
                <div class="health-ticker" aria-label="Health intelligence tips">
                    <div class="ticker-wrapper">
                        <p>
                            <span><i class="fas fa-brain" aria-hidden="true"></i> Optimize cognitive function with Mediterranean diet</span>
                            <span><i class="fas fa-heart-pulse" aria-hidden="true"></i> Maintain cardiovascular health through HIIT training</span>
                            <span><i class="fas fa-shield-virus" aria-hidden="true"></i> Boost immunity with probiotic-rich nutrition</span>
                            <span><i class="fas fa-lungs" aria-hidden="true"></i> Enhance respiratory wellness with deep breathing exercises</span>
                            <span><i class="fas fa-microscope" aria-hidden="true"></i> Leverage AI-powered preventive care analytics</span>
                            <span><i class="fas fa-dna" aria-hidden="true"></i> Support genetic wellness through personalized supplementation</span>
                            <span><i class="fas fa-bolt" aria-hidden="true"></i> Maximize energy metabolism with intermittent fasting protocols</span>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer Section -->
    <footer class="site-footer">
        <div class="container footer-container">

            <!-- About -->
            <div class="footer-about">
                <h3>HospiBridge</h3>
                <p>Your trusted healthcare partner, providing modern medical services with care and excellence.</p>
            </div>

            <!-- Quick Links -->
            <div class="footer-links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('services') }}">Services</a></li>
                    <li><a href="{{ url('/appointments') }}">Appointments</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="footer-contact">
                <h4>Contact Us</h4>
                <p><i class="fas fa-map-marker-alt"></i> Beirut, Lebanon</p>
                <p><i class="fas fa-phone"></i> +961 70 123 456</p>
                <p><i class="fas fa-envelope"></i> info@hospibridge.com</p>
                <div class="footer-social">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </div>
            </div>

        </div>

        <!-- Bottom -->
        <div class="footer-bottom">
            <p>&copy; 2025 HospiBridge. All Rights Reserved.</p>
        </div>
    </footer>
    <script>
AOS.init({
          duration: 1200,
          once: true
        });</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/site-effects.js') }}"></script>
    <script src="{{ asset('js/home.js') }}"></script>

    <!-- AI Symptom Triage Script -->
    <div id="chatbotDoctorsData" data-doctors="{{ $chatbotDoctors->toJson() }}" hidden></div>
    <script>
        const chatbotDoctors = JSON.parse(document.getElementById('chatbotDoctorsData').dataset.doctors || '[]');

        class SymptomTriageAI {
            constructor() {
                this.currentStep = 0;
                this.patientResponses = {};
                this.symptoms = [];
                this.questions = [
                    {
                        question: "Please describe your main symptom or concern.",
                        type: "open",
                        key: "main_symptom"
                    },
                    {
                        question: "How long have you been experiencing this symptom? (hours, days, weeks)",
                        type: "duration",
                        key: "duration"
                    },
                    {
                        question: "On a scale of 1-10, how severe is the symptom? (1 = mild, 10 = worst possible)",
                        type: "scale",
                        key: "severity"
                    },
                    {
                        question: "Do you have any of these additional symptoms? (Select all that apply)",
                        type: "multiple",
                        options: ["Fever", "Fatigue", "Nausea", "Dizziness", "Shortness of breath", "Chest pain", "Headache", "None of these"],
                        key: "additional_symptoms"
                    },
                    {
                        question: "Have you taken any medication for this symptom?",
                        type: "yesno",
                        key: "medication"
                    }
                ];

                this.specialties = {
                    cardiology: ["chest pain", "shortness of breath", "heart", "palpitations"],
                    emergency: ["severe pain", "difficulty breathing", "unconsciousness", "severe bleeding"],
                    neurology: ["headache", "dizziness", "confusion", "seizure"],
                    gastroenterology: ["nausea", "vomiting", "abdominal pain", "diarrhea"],
                    general: ["fever", "fatigue", "general weakness"]
                };

                this.doctors = chatbotDoctors.reduce((doctors, doctor) => {
                    const specialty = (doctor.specialty || 'general').toLowerCase();
                    doctors[specialty] ??= [];
                    doctors[specialty].push(doctor);
                    return doctors;
                }, {});

                this.init();
            }

            init() {
                this.chatContainer = document.getElementById('triageChat');
                this.patientInput = document.getElementById('patientInput');
                this.sendButton = document.getElementById('sendButton');
                this.aiStatus = document.getElementById('aiStatus');
                this.quickResponses = document.getElementById('quickResponses');

                this.sendButton.addEventListener('click', () => this.sendMessage());
                this.patientInput.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') this.sendMessage();
                });

                // Quick response buttons
                document.querySelectorAll('.quick-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        this.patientInput.value = btn.dataset.response;
                        this.sendMessage();
                    });
                });

                this.chatContainer.addEventListener('submit', (event) => {
                    if (event.target.id === 'chatbotBookingForm') {
                        submitChatbotAppointment(event);
                    }
                });
                this.startTriage();
            }

            startTriage() {
                this.patientInput.disabled = false;
                this.sendButton.disabled = false;
                this.aiStatus.textContent = "Asking questions...";
                this.askNextQuestion();
            }

            askNextQuestion() {
                if (this.currentStep < this.questions.length) {
                    const question = this.questions[this.currentStep];
                    this.addMessage("AI Assistant", question.question, "system");

                    if (question.type === "multiple") {
                        this.showMultipleChoice(question.options);
                    } else if (question.type === "yesno") {
                        this.showYesNoOptions();
                    }
                } else {
                    this.analyzeSymptoms();
                }
            }

            showMultipleChoice(options) {
                const optionsHtml = options.map(option =>
                    `<button class="option-btn" data-value="${option}">${option}</button>`
                ).join('');

                const optionsDiv = document.createElement('div');
                optionsDiv.className = 'chat-options';
                optionsDiv.innerHTML = optionsHtml;
                this.chatContainer.appendChild(optionsDiv);

                document.querySelectorAll('.option-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const selectedOptions = Array.from(document.querySelectorAll('.option-btn.selected'))
                            .map(b => b.dataset.value);

                        if (!selectedOptions.includes(btn.dataset.value)) {
                            btn.classList.add('selected');
                        } else {
                            btn.classList.remove('selected');
                        }
                    });
                });

                // Add submit button
                const submitBtn = document.createElement('button');
                submitBtn.className = 'btn btn-submit-options';
                submitBtn.textContent = 'Submit Selection';
                submitBtn.onclick = () => {
                    const selected = Array.from(document.querySelectorAll('.option-btn.selected'))
                        .map(b => b.dataset.value);
                    this.processResponse(selected.join(', ') || 'None selected');
                    optionsDiv.remove();
                    submitBtn.remove();
                };
                this.chatContainer.appendChild(submitBtn);
            }

            showYesNoOptions() {
                const yesNoHtml = `
                    <div class="yesno-options">
                        <button class="yesno-btn yes-btn" data-value="Yes">Yes</button>
                        <button class="yesno-btn no-btn" data-value="No">No</button>
                    </div>
                `;

                const optionsDiv = document.createElement('div');
                optionsDiv.className = 'chat-options';
                optionsDiv.innerHTML = yesNoHtml;
                this.chatContainer.appendChild(optionsDiv);

                document.querySelectorAll('.yesno-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        this.processResponse(btn.dataset.value);
                        optionsDiv.remove();
                    });
                });
            }

            sendMessage() {
                const message = this.patientInput.value.trim();
                if (message) {
                    this.addMessage("You", message, "patient");
                    this.processResponse(message);
                    this.patientInput.value = '';
                }
            }

            processResponse(response) {
                const currentQuestion = this.questions[this.currentStep];
                this.patientResponses[currentQuestion.key] = response;
                this.currentStep++;
                setTimeout(() => this.askNextQuestion(), 1000);
            }

            analyzeSymptoms() {
                this.aiStatus.textContent = "Analyzing symptoms...";

                const mainSymptom = this.patientResponses.main_symptom?.toLowerCase() || '';
                const additionalSymptoms = this.patientResponses.additional_symptoms?.toLowerCase() || '';
                const severity = parseInt(this.patientResponses.severity) || 1;

                let recommendedSpecialty = 'general';
                let urgency = 'low';

                // Determine specialty based on symptoms
                for (const [specialty, keywords] of Object.entries(this.specialties)) {
                    if (keywords.some(keyword => mainSymptom.includes(keyword) || additionalSymptoms.includes(keyword))) {
                        recommendedSpecialty = specialty;
                        break;
                    }
                }

                // Determine urgency based on severity and symptoms
                if (severity >= 8 || this.specialties.emergency.some(keyword =>
                    mainSymptom.includes(keyword) || additionalSymptoms.includes(keyword))) {
                    urgency = 'high';
                } else if (severity >= 6) {
                    urgency = 'medium';
                }

                const specialtyDoctors = this.doctors[recommendedSpecialty] || [];
                const scheduledDoctors = Object.values(this.doctors)
                    .flat()
                    .filter(doctor => doctor.schedules?.length);
                const availableDoctors = specialtyDoctors.length > 0
                    ? specialtyDoctors
                    : scheduledDoctors;
                const recommendedDoctor = availableDoctors.find(doctor => doctor.schedules?.length);

                if (!recommendedDoctor) {
                    this.showRecommendation(recommendedSpecialty, urgency, null, null);
                    return;
                }

                const futureSchedules = (recommendedDoctor.schedules || []).filter(schedule => {
                    const scheduleDate = new Date(`${schedule.date}T${schedule.start_time}`);
                    return !Number.isNaN(scheduleDate.getTime()) && scheduleDate >= new Date();
                });

                const schedule = futureSchedules[0] || null;
                const suggestedSlot = schedule ? `${schedule.date} ${schedule.start_time}` : null;

                setTimeout(() => {
                    this.showRecommendation(recommendedSpecialty, urgency, recommendedDoctor, schedule, suggestedSlot);
                }, 2000);
            }

            showRecommendation(specialty, urgency, doctor, schedule, slot) {
                this.aiStatus.textContent = "Recommendation ready";

                if (!doctor || !schedule) {
                    this.addMessage("AI Assistant", "There are no available doctors with schedules for this specialty right now. Please contact the center directly.", "result");
                    return;
                }

                const recommendation = `
                    <div class="recommendation-card">
                        <h4>Assessment Complete</h4>
                        <div class="rec-item"><strong>Specialty:</strong> ${specialty.charAt(0).toUpperCase() + specialty.slice(1)}</div>
                        <div class="rec-item"><strong>Urgency:</strong> <span class="urgency-${urgency}">${urgency.toUpperCase()}</span></div>
                        <div class="rec-item"><strong>Recommended Doctor:</strong> ${doctor.name}</div>
                        <div class="rec-item"><strong>Suggested Slot:</strong> ${slot}</div>
                        <button class="btn btn-book-now" type="button" onclick="showChatbotBookingForm()">Continue to Booking</button>
                        <form id="chatbotBookingForm" class="chatbot-booking-form" style="display:none;" novalidate>
                            <label for="chatbotName">Full Name</label>
                            <input id="chatbotName" type="text" required>
                            <label for="chatbotEmail">Email</label>
                            <input id="chatbotEmail" type="email" required>
                            <label for="chatbotPhone">Phone</label>
                            <input id="chatbotPhone" type="tel" required>
                            <label for="chatbotAppointmentType">Appointment Type</label>
                            <select id="chatbotAppointmentType" required>
                                <option value="normal">Normal Appointment</option>
                                <option value="telemedicine">Telemedicine Appointment</option>
                                <option value="vaccination">Vaccination Appointment</option>
                            </select>
                            <div id="chatbotTelemedicineFields" style="display:none;">
                                <label for="chatbotLocation">Current Location</label>
                                <input id="chatbotLocation" type="text">
                                <label for="chatbotUrgency">Urgency Level</label>
                                <select id="chatbotUrgency">
                                    <option value="">Select urgency</option>
                                    <option value="Critical">Critical</option>
                                    <option value="Urgent">Urgent</option>
                                    <option value="Moderate">Moderate</option>
                                </select>
                                <label for="chatbotWhishNumber">Your Whish Number</label>
                                <input id="chatbotWhishNumber" type="tel">
                                <label for="chatbotWhishReference">Whish Confirmation Code</label>
                                <input id="chatbotWhishReference" type="text">
                            </div>
                            <div id="chatbotVaccinationFields" style="display:none;">
                                <label for="chatbotVaccineName">Vaccine</label>
                                <select id="chatbotVaccineName">
                                    <option value="COVID-19">COVID-19</option>
                                    <option value="Flu">Flu</option>
                                    <option value="Hepatitis B">Hepatitis B</option>
                                </select>
                                <label for="chatbotDoseNumber">Dose Number</label>
                                <select id="chatbotDoseNumber">
                                    <option value="First dose">First dose</option>
                                    <option value="Second dose">Second dose</option>
                                    <option value="Booster">Booster</option>
                                </select>
                                <label for="chatbotVaccineDate">Date</label>
                                <input id="chatbotVaccineDate" type="date">
                            </div>
                            <label for="chatbotMessage">Message</label>
                            <textarea id="chatbotMessage"></textarea>
                            <button class="btn btn-book-now" type="submit">Book Appointment</button>
                            <p id="chatbotBookingStatus" role="status"></p>
                        </form>
                    </div>
                `;

                this.addMessage("AI Assistant", recommendation, "result");
                this.recommendedDoctor = doctor;
                this.recommendedSchedule = schedule;
                this.recommendedSlot = slot;
                this.patientInput.disabled = true;
                this.sendButton.disabled = true;
            }

            addMessage(speaker, content, type) {
                const messageDiv = document.createElement('div');
                messageDiv.className = `chat-line ${type}`;
                messageDiv.innerHTML = `
                    <span class="chat-speaker">${speaker}</span>
                    <div>${content}</div>
                `;
                this.chatContainer.appendChild(messageDiv);
                this.chatContainer.scrollTop = this.chatContainer.scrollHeight;
            }
        }

        // Initialize the AI when the page loads
        document.addEventListener('DOMContentLoaded', () => {
            window.symptomTriageAI = new SymptomTriageAI();
        });

        function showChatbotBookingForm() {
            const form = document.getElementById('chatbotBookingForm');
            if (!form) {
                return;
            }

            form.style.display = 'block';
            document.getElementById('chatbotAppointmentType').dispatchEvent(new Event('change'));
            form.querySelector('#chatbotName').focus();
        }

        function submitChatbotAppointment(event) {
            event.preventDefault();
            const chatbot = window.symptomTriageAI;
            const type = document.getElementById('chatbotAppointmentType').value;
            const status = document.getElementById('chatbotBookingStatus');
            const formData = new FormData();
            const phone = document.getElementById('chatbotPhone').value.trim();

            if (!event.target.checkValidity()) {
                status.textContent = 'Please complete the booking fields.';
                event.target.classList.add('has-validation-error');
                event.target.querySelector(':invalid')?.focus();
                return;
            }

            if (!phone.replace(/\D/g, '')) {
                status.textContent = 'Please enter a valid phone number.';
                return;
            }

            status.textContent = 'Submitting appointment...';
            event.target.querySelector('button[type="submit"]').disabled = true;

            formData.append('appointment_type', type);
            formData.append('name', document.getElementById('chatbotName').value.trim());
            formData.append('email', document.getElementById('chatbotEmail').value.trim());
            formData.append('phone', phone);
            formData.append('doctor_id', chatbot.recommendedDoctor.id);
            formData.append('schedule_id', chatbot.recommendedSchedule.id);
            formData.append('symptoms', `${chatbot.patientResponses.main_symptom || ''} ${chatbot.patientResponses.additional_symptoms || ''}`.trim());
            formData.append('message', document.getElementById('chatbotMessage').value.trim() || `Booked via symptom triage for ${chatbot.recommendedDoctor.name} at ${chatbot.recommendedSlot}`);

            if (type === 'telemedicine') {
                formData.append('location', document.getElementById('chatbotLocation').value.trim());
                formData.append('urgency', document.getElementById('chatbotUrgency').value);
                formData.append('whish_number', document.getElementById('chatbotWhishNumber').value.trim());
                formData.append('whish_reference', document.getElementById('chatbotWhishReference').value.trim());
            }

            if (type === 'vaccination') {
                formData.append('vaccine_name', document.getElementById('chatbotVaccineName').value);
                formData.append('dose_number', document.getElementById('chatbotDoseNumber').value);
                formData.append('vaccine_date', document.getElementById('chatbotVaccineDate').value);
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            fetch('/appointments', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken || ''
                },
                body: formData
            })
                .then(async (res) => {
                    const contentType = res.headers.get('content-type') || '';
                    const payload = contentType.includes('application/json') ? await res.json() : {};

                    if (!res.ok || !payload.success) {
                        throw payload || { message: 'The booking could not be completed right now. Please try again.' };
                    }

                    return payload;
                })
                .then(response => {
                    status.textContent = response.message || 'Appointment booked and sent for admin confirmation.';
                    event.target.reset();
                    event.target.querySelector('button[type="submit"]').disabled = false;
                })
                .catch((error) => {
                    status.textContent = error?.message || 'The booking could not be completed right now. Please try again.';
                    event.target.querySelector('button[type="submit"]').disabled = false;
                });
        }

        document.addEventListener('change', (event) => {
            if (event.target.id !== 'chatbotAppointmentType') {
                return;
            }

            const telemedicine = event.target.value === 'telemedicine';
            const vaccination = event.target.value === 'vaccination';
            document.getElementById('chatbotTelemedicineFields').style.display = telemedicine ? 'block' : 'none';
            document.getElementById('chatbotVaccinationFields').style.display = vaccination ? 'block' : 'none';
            ['chatbotLocation', 'chatbotUrgency', 'chatbotWhishNumber', 'chatbotWhishReference'].forEach(id => {
                document.getElementById(id).required = telemedicine;
            });
            document.getElementById('chatbotVaccineDate').required = vaccination;
        });
    </script>




</body>
</html>