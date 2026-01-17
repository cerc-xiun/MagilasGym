<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Membership | Magilas Gym</title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- CSS -->
    <link rel="stylesheet" href="../../css/variables.css">
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="../../css/auth.css">
    
    <link rel="icon" type="image/png" href="../../assets/images/logo.png">
</head>
<body>
    <!-- Preloader -->
    <div class="loading-overlay active" id="preloader" style="background: var(--color-bg);">
        <div class="loading-spinner"></div>
        <div class="loading-text">MAGILAS</div>
    </div>

    <!-- Background Overlay -->
    <div class="auth-page">
        <a href="landing.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Home
        </a>

        <div class="auth-container animate-slide-up">
            <div class="auth-card">
                <header class="auth-header">
                    <img src="../../assets/images/logo.png" alt="Magilas Logo" class="auth-logo">
                    <h1 class="auth-title">Apply for <span class="text-accent">Membership</span></h1>
                    <p class="auth-subtitle">Submit your details for staff approval</p>
                </header>

                <form class="auth-form" id="registerForm" novalidate>
                    <!-- Personal Info -->
                    <div class="form-group">
                        <label for="fullname" class="form-label">Full Name</label>
                        <input type="text" id="fullname" name="fullname" class="form-input" placeholder="Juan Dela Cruz" required autocomplete="name">
                        <span class="form-error" id="fullnameError"></span>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" id="email" name="email" class="form-input" placeholder="juan@email.com" required autocomplete="email">
                        <span class="form-error" id="emailError"></span>
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" id="phone" name="phone" class="form-input" placeholder="09XX XXX XXXX" required autocomplete="tel">
                        <span class="form-error" id="phoneError"></span>
                    </div>

                    <!-- Photo Upload -->
                    <div class="form-group">
                        <label class="form-label">Profile Photo</label>
                        <div class="file-upload" id="dropZone">
                            <input type="file" id="photo" name="photo" accept="image/*" required>
                            <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: var(--color-accent); margin-bottom: var(--space-2);"></i>
                            <p style="margin: 0; color: var(--color-text-secondary); font-weight: 500;">Click or Drag photo here</p>
                            <small class="text-muted" style="display: block; margin-top: var(--space-2);">Max size: 5MB (JPG, PNG)</small>
                            <div class="file-preview" id="filePreview"></div>
                        </div>
                        <span class="form-error" id="photoError"></span>
                    </div>

                    <div class="tip-box" style="margin-bottom: var(--space-6);">
                        <i class="fas fa-info-circle tip-icon text-accent"></i>
                        <span class="tip-text">
                            <strong>Note:</strong> This is a pre-registration application. Final approval and payment will be handled at the gym front desk.
                        </span>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg btn-block" id="submitBtn">
                        <span>📝</span> Submit Application
                    </button>
                    
                </form>
            </div>
        </div>
    </div>

    <!-- Loading Overlay for Form Submission -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
        <div class="loading-text">SUBMITTING APPLICATION...</div>
    </div>

    <!-- JavaScript -->
    <script>
    // Preloader
    window.addEventListener('load', () => {
        setTimeout(() => {
            const preloader = document.getElementById('preloader');
            preloader.style.opacity = '0';
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500);
        }, 800);
    });

    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('registerForm');
        const fileInput = document.getElementById('photo');
        const dropZone = document.getElementById('dropZone');
        const filePreview = document.getElementById('filePreview');
        const loadingOverlay = document.getElementById('loadingOverlay');

        // File Upload Handling
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            dropZone.style.borderColor = 'var(--color-accent)';
            dropZone.style.background = 'rgba(212, 175, 0, 0.05)';
        }

        function unhighlight() {
            dropZone.style.borderColor = 'var(--color-border)';
            dropZone.style.background = 'rgba(255, 255, 255, 0.02)';
        }

        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            handleFiles(files);
        }

        fileInput.addEventListener('change', function() {
            handleFiles(this.files);
        });

        function handleFiles(files) {
            if (files.length > 0) {
                const file = files[0];
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        filePreview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="animate-fade-in">`;
                        document.getElementById('photoError').textContent = '';
                    }
                    reader.readAsDataURL(file);
                } else {
                    showError('photo', 'Please upload an image file');
                }
            }
        }

        // Form Validation & Submission
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            
            // Reset errors
            document.querySelectorAll('.form-error').forEach(el => el.textContent = '');
            
            let isValid = true;
            const formData = new FormData(form);

            if (!formData.get('fullname').trim()) {
                showError('fullname', 'Full name is required');
                isValid = false;
            }
            if (!formData.get('email').includes('@')) {
                showError('email', 'Please enter a valid email');
                isValid = false;
            }
            if (!formData.get('phone').match(/^[0-9+]+$/)) {
                showError('phone', 'Please enter a valid phone number');
                isValid = false;
            }
            if (fileInput.files.length === 0) {
                showError('photo', 'Profile photo is required');
                isValid = false;
            }

            if (isValid) {
                loadingOverlay.classList.add('active');
                
                setTimeout(() => {
                    loadingOverlay.classList.remove('active');
                    window.location.href = 'application_submitted.php';
                }, 2000);
            }
        });

        function showError(fieldId, message) {
            const errorElement = document.getElementById(`${fieldId}Error`);
            if (errorElement) {
                errorElement.textContent = message;
            }
        }
    });
    </script>
</body>
</html>