document.addEventListener('DOMContentLoaded', function() {
    // No initialization needed for our direct PHP approach
    
    const bidForm = document.getElementById('bidForm');
    const bidAmount = document.getElementById('bidAmount');
    const bidError = document.getElementById('bidError');
    const minBid = 150;
    
    // Set recipient email
    const recipientEmail = "mail.esstafasoufiane@gmail.com";

    // Ensure proper formatting and validation for mobile devices
    if (bidAmount) {
        // Set initial placeholder with currency
        bidAmount.setAttribute('placeholder', `Enter your bid (min $${minBid})`);
        
        // Validate bid amount on input
        bidAmount.addEventListener('input', function() {
            validateBidAmount();
        });
        
        // Also validate on blur for better mobile experience
        bidAmount.addEventListener('blur', function() {
            validateBidAmount();
        });
    }

    // Validate bid amount
    function validateBidAmount() {
        const value = parseFloat(bidAmount.value);
        
        if (isNaN(value) || value < minBid) {
            bidError.textContent = `Minimum bid amount is $${minBid}`;
            bidAmount.setAttribute('aria-invalid', 'true');
            return false;
        } else {
            bidError.textContent = '';
            bidAmount.setAttribute('aria-invalid', 'false');
            return true;
        }
    }

    // Form submission
    if (bidForm) {
        bidForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate bid amount
            if (!validateBidAmount()) {
                bidAmount.focus();
                return false;
            }
            
            // Get form values
            const amount = bidAmount.value;
            const email = document.getElementById('email').value;
            const industry = document.getElementById('industry').value || "Not specified";
            const message = document.getElementById('message').value || "No message provided";
            
            // Show loading state
            const submitBtn = bidForm.querySelector('.submit-btn');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span>Sending...</span>';
            submitBtn.disabled = true;
            
            // Method 1: Send email using EmailJS
            sendEmailWithEmailJS(amount, email, industry, message)
                .then(function() {
                    console.log('Email sent successfully with EmailJS');
                    showSuccessMessage(amount, email, industry);
                    bidForm.reset();
                })
                .catch(function(error) {
                    console.error('EmailJS failed:', error);
                    // Method 2: Send email using a simple mailto link as fallback
                    sendEmailWithMailto(amount, email, industry, message);
                })
                .finally(function() {
                    // Reset button state
                    submitBtn.innerHTML = originalBtnText;
                    submitBtn.disabled = false;
                });
            
            return false;
        });
    }
    
    // Send email using our PHP script
    function sendEmailWithEmailJS(amount, email, industry, message) {
        // Prepare data for the PHP script
        const data = {
            amount: amount,
            email: email,
            industry: industry,
            message: message
        };
        
        // Send data to our PHP script
        return fetch('send-email.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        }).then(data => {
            if (!data.success) {
                throw new Error(data.message || 'Failed to send email');
            }
            return data;
        });
    }
    
    // Fallback method using mailto link
    function sendEmailWithMailto(amount, email, industry, message) {
        const subject = encodeURIComponent(`New Bid for Rocketshub.com: $${amount}`);
        const body = encodeURIComponent(
            `Bid Amount: $${amount}\n\n` +
            `Bidder Email: ${email}\n\n` +
            `Industry: ${industry}\n\n` +
            `Message: ${message}\n\n`
        );
        
        // Create a temporary link and click it
        const mailtoLink = document.createElement('a');
        mailtoLink.href = `mailto:${recipientEmail}?subject=${subject}&body=${body}`;
        mailtoLink.style.display = 'none';
        document.body.appendChild(mailtoLink);
        mailtoLink.click();
        document.body.removeChild(mailtoLink);
        
        // Show success message
        showSuccessMessage(amount, email, industry);
    }
    
    // Function to display success message
    function showSuccessMessage(amount, email, industry) {
        const bidForm = document.getElementById('bidForm');
        
        // Remove any existing success messages
        const existingMessages = document.querySelectorAll('.success-message');
        existingMessages.forEach(msg => msg.remove());
        
        // Show success message
        const successMessage = document.createElement('div');
        successMessage.className = 'success-message';
        successMessage.style.display = 'block';
        successMessage.setAttribute('role', 'alert');
        
        // Customize message based on industry
        let industryText = '';
        if (industry) {
            if (industry === 'aerospace' || industry === 'rocket-tracking') {
                industryText = 'This domain is perfect for your aerospace venture!';
            } else if (industry === 'technology' || industry === 'saas') {
                industryText = 'A great choice for your tech platform or SaaS business!';
            } else if (industry === 'platform') {
                industryText = 'An excellent foundation for your platform business!';
            }
        }
        
        successMessage.innerHTML = `
            <p><strong>Thank you for your bid of $${amount}!</strong></p>
            <p>Your bid has been sent to the domain owner.</p>
            <p>We'll contact you at ${email} shortly to discuss the next steps.</p>
            ${industryText ? `<p>${industryText}</p>` : ''}
        `;
        
        // Insert success message after the form
        bidForm.insertAdjacentElement('afterend', successMessage);
        
        // Scroll to success message with a slight delay for better UX
        setTimeout(() => {
            successMessage.scrollIntoView({ 
                behavior: 'smooth',
                block: 'nearest'
            });
        }, 100);
    }

    // Add touch support for mobile devices
    document.querySelectorAll('button, input, textarea').forEach(element => {
        element.addEventListener('touchstart', function() {
            this.classList.add('touch-active');
        });
        
        element.addEventListener('touchend', function() {
            this.classList.remove('touch-active');
        });
    });

    // Handle viewport height issues on mobile browsers
    function setVH() {
        let vh = window.innerHeight * 0.01;
        document.documentElement.style.setProperty('--vh', `${vh}px`);
    }

    // Set the height initially and on resize
    setVH();
    window.addEventListener('resize', setVH);
    window.addEventListener('orientationchange', setVH);
});