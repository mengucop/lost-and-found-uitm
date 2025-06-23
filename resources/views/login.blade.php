<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>UITM Lost & Found</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    /* Cyberpunk-style animated background */
    body {
      background: linear-gradient(135deg, #0f172a, #1e293b);
      background-size: 400% 400%;
      animation: gradientAnimation 15s ease infinite;
      font-family: 'Poppins', sans-serif;
    }

    @keyframes gradientAnimation {
      0% {
        background-position: 0% 50%;
      }
      50% {
        background-position: 100% 50%;
      }
      100% {
        background-position: 0% 50%;
      }
    }

    /* Glowing Text */
    .glow-text {
      text-shadow: 0 0 10px rgba(96, 165, 250, 0.8),
                   0 0 20px rgba(139, 92, 246, 0.6);
    }

    /* Neon Effect on Inputs and Buttons */
    .cyber-input {
      background: rgba(15, 23, 42, 0.7);
      border: 1px solid #334155;
      transition: all 0.3s ease;
      color: white;
    }

    .cyber-input:focus {
      border-color: #60a5fa;
      box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.3);
      outline: none;
    }

    .neon-btn {
      background: linear-gradient(135deg, #3b82f6, #8b5cf6);
      padding: 0.75rem 2rem;
      color: white;
      font-weight: bold;
      border-radius: 0.75rem;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      position: relative;
      overflow: hidden;
      box-shadow: 0 0 15px rgba(96, 165, 250, 0.6);
    }

    .neon-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 0 25px rgba(96, 165, 250, 0.6),
                  0 0 30px rgba(139, 92, 246, 0.4);
    }

    .neon-btn::after {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: linear-gradient(
        to bottom right,
        rgba(255, 255, 255, 0) 0%,
        rgba(255, 255, 255, 0.2) 50%,
        rgba(255, 255, 255, 0) 100%
      );
      transform: rotate(25deg);
      animation: shine 3s infinite;
    }

    @keyframes shine {
      0% { left: -50%; }
      100% { left: 150%; }
    }

    /* Hero Header Background Color */
    .hero-header {
      background-color: rgba(0, 0, 0, 0.1);
      background-image: linear-gradient(135deg, rgba(32, 37, 43, 0.8), rgba(0, 0, 0, 0));
      color: white;
    }

    /* Header Glowing Text */
    .header-text {
      text-shadow: 0 0 15px rgba(96, 165, 250, 1),
                   0 0 30px rgba(139, 92, 246, 0.6);
    }

    /* Logo Glowing Effect */
    .logo {
      filter: drop-shadow(0 0 15px rgba(96, 165, 250, 1));
      transition: filter 0.3s ease;
    }

    .logo:hover {
      filter: drop-shadow(0 0 30px rgba(96, 165, 250, 1));
    }

    /* Modal Styling */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.7);
      z-index: 50;
      justify-content: center;
      align-items: center;
      animation: fadeIn 0.3s ease-in-out;
    }

    .modal.active {
      display: flex;
    }

    .modal-content {
      background: rgba(50, 50, 50, 0.9);
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
      max-width: 500px;
      width: 90%;
      max-height: 90vh;
      overflow-y: auto;
    }

    /* FAQ Modal - Slightly Lighter Background */
    #faqModal .modal-content {
      background: rgba(60, 60, 70, 0.95);
    }

    @keyframes fadeIn {
      0% { opacity: 0; }
      100% { opacity: 1; }
    }

    /* Footer */
    footer {
      background-color: rgba(0, 0, 0, 0.8);
      color: white;
      padding: 20px;
      text-align: center;
    }

    /* FAQ Section Styles */
    .faq-container {
      margin-top: 20px;
    }

    .faq-item {
      background: rgba(30, 41, 59, 0.8);
      border: 1px solid #334155;
      border-radius: 0.5rem;
      margin-bottom: 0.75rem;
      overflow: hidden;
    }

    .faq-question {
      padding: 1rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      cursor: pointer;
      transition: background 0.3s ease;
      color: #93c5fd;
    }

    .faq-question:hover {
      background: rgba(51, 65, 85, 0.5);
    }

    .faq-answer {
      padding: 0 1rem;
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.3s ease, padding 0.3s ease;
      color: #e2e8f0;
    }

    .faq-answer.active {
      padding: 0 1rem 1rem 1rem;
      max-height: 500px;
    }

    .faq-toggle {
      transition: transform 0.3s ease;
      color: #60a5fa;
    }

    .faq-toggle.active {
      transform: rotate(180deg);
    }

    .close-btn {
      position: absolute;
      top: 15px;
      right: 15px;
      color: #93c5fd;
      font-size: 1.5rem;
      cursor: pointer;
      transition: color 0.3s ease;
    }

    .close-btn:hover {
      color: #60a5fa;
    }

    /* FAQ title */
    .faq-title {
      text-align: center;
      font-size: 1.8rem;
      margin-bottom: 1.5rem;
      color: #93c5fd;
      text-shadow: 0 0 10px rgba(96, 165, 250, 0.5);
    }

    /* Top navigation buttons container */
    .nav-buttons {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    /* FAQ button specific style */
    .faq-btn {
      background: linear-gradient(135deg, #8b5cf6, #ec4899);
      padding: 0.5rem 1.5rem;
      font-size: 0.9rem;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .nav-buttons {
        flex-direction: row;
        gap: 8px;
      }

      .faq-btn, .login-btn {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
      }

      .modal-content {
        padding: 25px;
      }
    }
  </style>
</head>
<body class="text-gray-100 font-mono">

  <!-- Top Navigation -->
  <div class="w-full absolute top-0 left-0 flex justify-between items-center p-4 z-50">
    <!-- UiTM Logo -->
    <div class="flex items-center space-x-3">
      <img src="public\images\uitmlogo.png"
           alt="UiTM Logo" class="logo h-28 w-auto"/>
      <span class="text-white font-bold text-lg hidden sm:inline">UiTM Lost & Found</span>
    </div>

    <!-- FAQ and Login Buttons -->
    <div class="nav-buttons">
      <button onclick="openModal('faqModal')" class="neon-btn faq-btn">
        <i class="fas fa-question-circle mr-2"></i>FAQ
      </button>
      <button onclick="openModal('loginModal')" class="neon-btn login-btn">
        <i class="fas fa-sign-in-alt mr-2"></i>Login
      </button>
    </div>
  </div>

  <!-- Hero Header Section -->
  <header class="relative w-full h-[90vh] flex items-center justify-center text-center overflow-hidden hero-header">
    <img src="images/uitmlogo.png"
         alt="Cyberpunk UiTM"
         class="absolute inset-0 w-full h-full object-cover opacity-20 brightness-75 z-[-1]">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-900/50 via-purple-800/40 to-black/70 z-[-1]"></div>
    <div class="px-6 max-w-4xl">
      <h1 class="text-5xl md:text-6xl font-bold text-white header-text leading-tight drop-shadow-lg">
      UiTM Lost & Found
      </h1>
      <p class="mt-4 text-xl text-blue-200 italic">
        Connecting the lost items to their rightful owners.
      </p>


    <!-- Animated floating items -->
    <div class="absolute bottom-10 left-10 w-16 h-16 rounded-full bg-blue-500/20 animate-pulse"></div>
    <div class="absolute top-20 right-20 w-12 h-12 rounded-full bg-purple-500/20 animate-pulse"></div>
    <div class="absolute top-1/3 left-1/4 w-10 h-10 rounded-full bg-pink-500/20 animate-pulse"></div>
  </header>

  <!-- Modal for Login -->
  <div id="loginModal" class="modal">
    <div class="modal-content relative">
      <span class="close-btn" onclick="closeModals()">&times;</span>
      <div class="text-center">
        <h2 class="text-2xl text-blue-400">Login</h2>
        <p class="text-blue-200 mt-2 mb-4">Please enter your credentials</p>
      </div>
      <form action="{{ route('login.perform') }}" method="post" class="space-y-6">
        @csrf
        <div>
          <label class="block text-sm text-blue-200/90">Email</label>
          <input class="w-full px-4 py-3 rounded-lg cyber-input" type="email" name="email" placeholder="student@uitm.edu.my" required autocomplete="username">
        </div>
        <div>
          <label class="block text-sm text-blue-200/90">Password</label>
          <input class="w-full px-4 py-3 rounded-lg cyber-input" type="password" name="password" placeholder="Enter your password" required autocomplete="current-password">
        </div>
        <button type="submit" class="w-full py-3 px-4 rounded-lg font-medium neon-btn text-white">
          Login
        </button>
      </form>
      <div class="mt-4 text-sm text-center">
        <span>Don't have an account? </span>
        <a href="/register" class="text-blue-300 hover:text-blue-400">Register here</a>
      </div>
    </div>
  </div>

  <!-- Modal for FAQ -->
  <div id="faqModal" class="modal">
    <div class="modal-content relative">
      <span class="close-btn" onclick="closeModals()">&times;</span>
      <h2 class="faq-title">Frequently Asked Questions</h2>

      <div class="faq-container">
        <div class="faq-item">
          <div class="faq-question" onclick="toggleFAQAnswer(this)">
            <span>How do I reset my password?</span>
            <i class="fas fa-chevron-down faq-toggle"></i>
          </div>
          <div class="faq-answer">
            <p>If you've forgotten your password, click on the "Forgot Password" link on the login page. You'll receive password reset instructions via your registered email address.</p>
          </div>
        </div>

        <div class="faq-item">
          <div class="faq-question" onclick="toggleFAQAnswer(this)">
            <span>Who can use the Lost & Found service?</span>
            <i class="fas fa-chevron-down faq-toggle"></i>
          </div>
          <div class="faq-answer">
            <p>This service is available to all UiTM students, staff, and faculty members. You need a valid UiTM email address to register and use the system.</p>
          </div>
        </div>

        <div class="faq-item">
          <div class="faq-question" onclick="toggleFAQAnswer(this)">
            <span>What should I do if I found an item?</span>
            <i class="fas fa-chevron-down faq-toggle"></i>
          </div>
          <div class="faq-answer">
            <p>Log in to your account and click "Report Found Item". Provide details about the item and where you found it. The system will notify potential owners and campus security.</p>
          </div>
        </div>

        <div class="faq-item">
          <div class="faq-question" onclick="toggleFAQAnswer(this)">
            <span>How long are items kept at lost & found?</span>
            <i class="fas fa-chevron-down faq-toggle"></i>
          </div>
          <div class="faq-answer">
            <p>Found items are kept for 30 days at campus security offices. After this period, unclaimed items may be donated to charity or disposed of according to university policy.</p>
          </div>
        </div>
      </div>

      <div class="mt-8 text-center">
        <p class="text-blue-200">Still have questions? Contact campus security:</p>
        <p class="text-blue-300 mt-2">
          <i class="fas fa-phone mr-2"></i>+603-5544 2000<br>
          <i class="fas fa-envelope mr-2 mt-2"></i>security@uitm.edu.my
        </p>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    <p class="text-sm text-white">© 2025 UiTM. All rights reserved.</p>
  </footer>

  <script>
    // Function to open modals
    function openModal(modalId) {
      closeModals();
      document.getElementById(modalId).classList.add('active');
    }

    // Function to close all modals
    function closeModals() {
      document.querySelectorAll('.modal').forEach(modal => {
        modal.classList.remove('active');
      });
    }

    // Toggle individual FAQ answers
    function toggleFAQAnswer(element) {
      const answer = element.nextElementSibling;
      const icon = element.querySelector('.faq-toggle');

      answer.classList.toggle('active');
      icon.classList.toggle('active');
    }

    // Close modals when clicking outside
    window.onclick = function(event) {
      if (event.target.classList.contains('modal')) {
        closeModals();
      }
    }

    // Close modal with ESC key
    document.addEventListener('keydown', function(event) {
      if (event.key === 'Escape') {
        closeModals();
      }
    });
  </script>

</body>
</html>
