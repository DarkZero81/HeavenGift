@extends('layouts.app')

@section('title', 'Contact')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        .contact-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 4rem 0;
            margin-bottom: 3rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .contact-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .contact-hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 1;
        }

        .contact-hero p {
            font-size: 1.3rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .contact-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .contact-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            margin-bottom: 4rem;
        }

        .contact-info {
            background: white;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            height: fit-content;
            position: relative;
            overflow: hidden;
        }

        .contact-info::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .contact-info h3 {
            color: #2c3e50;
            font-size: 1.8rem;
            margin-bottom: 2rem;
            font-weight: 600;
        }

        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: #f8f9fa;
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .contact-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .contact-item i {
            font-size: 1.5rem;
            color: #667eea;
            margin-right: 1rem;
            width: 40px;
            text-align: center;
        }

        .contact-item div h4 {
            color: #2c3e50;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .contact-item div p {
            color: #6c757d;
            margin: 0;
        }

        .contact-form {
            background: white;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .contact-form::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #764ba2, #667eea);
        }

        .contact-form h3 {
            color: #2c3e50;
            font-size: 1.8rem;
            margin-bottom: 2rem;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 2rem;
        }

        .form-label {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 0.8rem;
            display: block;
            font-size: 1.1rem;
        }

        .form-control {
            width: 100%;
            padding: 1rem 1.5rem;
            border: 2px solid #e9ecef;
            border-radius: 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control:focus {
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            outline: none;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 3rem;
            border: none;
            border-radius: 15px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-submit:hover::before {
            left: 100%;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white !important;
            border-radius: 50%;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1.2rem;
        }

        .social-link i {
            color: white !important;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 17px;
        }

        .social-link:hover {
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        @media (max-width: 768px) {
            .contact-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .contact-hero h1 {
                font-size: 2.5rem;
            }

            .contact-hero p {
                font-size: 1.1rem;
            }

            .contact-info,
            .contact-form {
                padding: 2rem;
            }

            .contact-container {
                padding: 0 1rem;
            }
        }
    </style>

    <div class="contact-hero">
        <div class="contact-container">
            <h1><i class="bi bi-chat-dots-fill"></i> Get In Touch</h1>
            <p>We'd love to hear from you! Send us a message and we'll respond as soon as possible.</p>
        </div>
    </div>

    <div class="contact-container">
        <div class="contact-content">
            <div class="contact-info">
                <h3><i class="bi bi-info-circle-fill"></i> Contact Information</h3>

                <div class="contact-item">
                    <i class="bi bi-geo-alt-fill"></i>
                    <div>
                        <h4>Visit Our Store</h4>
                        <p>123 Commerce Street<br>Business District, City 12345</p>
                    </div>
                </div>

                <div class="contact-item">
                    <i class="bi bi-telephone-fill"></i>
                    <div>
                        <h4>Call Us</h4>
                        <p>+1 (555) 123-4567<br>Mon-Fri 9AM-6PM</p>
                    </div>
                </div>

                <div class="contact-item">
                    <i class="bi bi-envelope-fill"></i>
                    <div>
                        <h4>Email Us</h4>
                        <p>info@yourstore.com<br>support@yourstore.com</p>
                    </div>
                </div>

                <div class="contact-item">
                    <i class="bi bi-clock-fill"></i>
                    <div>
                        <h4>Business Hours</h4>
                        <p>Monday - Friday: 9AM - 6PM<br>Saturday: 10AM - 4PM<br>Sunday: Closed</p>
                    </div>
                </div>

                <div class="contact-item">
                    <i class="bi bi-share-fill"></i>
                    <div>
                        <h4>Follow Us</h4>
                        <div class="social-links">
                            <a href="#" class="social-link" title="Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="#" class="social-link" title="X (Twitter)">
                                <i class="bi bi-twitter-x"></i>
                            </a>
                            <a href="#" class="social-link" title="Instagram">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="#" class="social-link" title="TikTok">
                                <i class="bi bi-tiktok"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="contact-form">
                <h3><i class="bi bi-send-fill"></i> Send us a Message</h3>

                <form method="POST" action="#">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-label">
                            <i class="bi bi-person-fill"></i> Full Name
                        </label>
                        <input type="text" name="name" id="name" class="form-control"
                            placeholder="Enter your full name" required>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope-fill"></i> Email Address
                        </label>
                        <input type="email" name="email" id="email" class="form-control"
                            placeholder="Enter your email address" required>
                    </div>

                    <div class="form-group">
                        <label for="subject" class="form-label">
                            <i class="bi bi-subject"></i> Subject
                        </label>
                        <input type="text" name="subject" id="subject" class="form-control"
                            placeholder="What's this about?">
                    </div>

                    <div class="form-group">
                        <label for="message" class="form-label">
                            <i class="bi bi-chat-text-fill"></i> Message
                        </label>
                        <textarea name="message" id="message" class="form-control" placeholder="Tell us more about your inquiry..."
                            rows="6" required></textarea>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="bi bi-send"></i> Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
