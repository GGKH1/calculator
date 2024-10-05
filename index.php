<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP Calculator with Tailwind and Keyboard Support</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
  <div class="bg-gray-800 text-white p-6 rounded-lg shadow-lg w-80">
    <form method="POST">
      <input type="text" name="display" id="display"
        value="<?php echo isset($_POST['display']) ? $_POST['display'] : ''; ?>"
        class="w-full bg-gray-700 p-4 text-right text-2xl rounded mb-4"
        readonly>

      <div class="grid grid-cols-4 gap-2">
        <!-- First row -->
        <button type="button" data-key="C" class="bg-red-500 rounded-full text-white text-2xl p-4">C</button>
        <button type="button" data-key="/" class="bg-yellow-500 rounded-full text-white text-2xl p-4">÷</button>
        <button type="button" data-key="*" class="bg-yellow-500 rounded-full text-white text-2xl p-4">×</button>
        <button type="button" data-key="-" class="bg-yellow-500 rounded-full text-white text-2xl p-4">−</button>

        <!-- Second row -->
        <button type="button" data-key="7" class="bg-gray-600 rounded-full text-white text-2xl p-4">7</button>
        <button type="button" data-key="8" class="bg-gray-600 rounded-full text-white text-2xl p-4">8</button>
        <button type="button" data-key="9" class="bg-gray-600 rounded-full text-white text-2xl p-4">9</button>
        <button type="button" data-key="+" class="bg-yellow-500 rounded-full text-white text-2xl p-4">+</button>

        <!-- Third row -->
        <button type="button" data-key="4" class="bg-gray-600 rounded-full text-white text-2xl p-4">4</button>
        <button type="button" data-key="5" class="bg-gray-600 rounded-full text-white text-2xl p-4">5</button>
        <button type="button" data-key="6" class="bg-gray-600 rounded-full text-white text-2xl p-4">6</button>
        <button type="button" data-key="=" class="bg-green-500 rounded-full text-white text-2xl p-4 row-span-2">=</button>

        <!-- Fourth row -->
        <button type="button" data-key="1" class="bg-gray-600 rounded-full text-white text-2xl p-4">1</button>
        <button type="button" data-key="2" class="bg-gray-600 rounded-full text-white text-2xl p-4">2</button>
        <button type="button" data-key="3" class="bg-gray-600 rounded-full text-white text-2xl p-4">3</button>

        <!-- Fifth row -->
        <button type="button" data-key="0" class="bg-gray-600 rounded-full text-white text-2xl p-4 col-span-2">0</button>
        <button type="button" data-key="." class="bg-gray-600 rounded-full text-white text-2xl p-4">.</button>
      </div>
    </form>
  </div>

  <?php
  // Initialize variables
  $display = '';
  $result = '';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['clear'])) {
      $display = '';
    } elseif (isset($_POST['number']) || isset($_POST['operator'])) {
      $display = $_POST['display'] . $_POST['number'] . $_POST['operator'];
    } elseif (isset($_POST['equals'])) {
      $display = $_POST['display'];
      $result = eval('return ' . str_replace(['×', '÷'], ['*', '/'], $display) . ';');
      $display = $result;
    }
  }

  // Re-populate the display value
  echo "<script>document.getElementById('display').value = '$display';</script>";
  ?>

  <script>
    // JavaScript for keyboard and button functionality
    const display = document.getElementById('display');
    const buttons = document.querySelectorAll('button[data-key]');

    // Handle button click
    buttons.forEach(button => {
      button.addEventListener('click', function() {
        const key = this.getAttribute('data-key');
        handleInput(key);
      });
    });

    // Handle keyboard input
    window.addEventListener('keydown', function(e) {
      const key = e.key;
      if (/[0-9+\-*/.=C]/.test(key)) {
        handleInput(key);
      } else if (key === 'Enter') {
        handleInput('=');
      } else if (key === 'Escape') {
        handleInput('C');
      }
    });

    // Function to process input
    function handleInput(key) {
      if (key === 'C') {
        display.value = '';
      } else if (key === '=') {
        try {
          // Safely evaluate the expression
          display.value = eval(display.value.replace(/×/g, '*').replace(/÷/g, '/'));
        } catch (err) {
          display.value = 'Error';
        }
      } else {
        display.value += key;
      }
    }
  </script>

</body>

</html>