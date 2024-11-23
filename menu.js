function calculateTotalPrice() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    let totalPrice = 0;
  
    checkboxes.forEach((checkbox) => {
      if (checkbox.checked) {
        // Assuming each checkbox's value represents its price
        totalPrice += parseFloat(checkbox.value);
      }
    });
  
    // Display the total price below the menu container
    const totalPriceElement = document.getElementById('total-price');
    totalPriceElement.textContent = `Total Price: $${totalPrice.toFixed(2)}`;
  }