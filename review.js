function fetchAndDisplayData() {
    // Fetch data from other pages and set the content in the review page
    // This is a simplified example; in real-world applications, you would use AJAX or fetch to get data from the server.
    document.getElementById('hotel-name').innerText += 'Hotel XYZ';
    document.getElementById('menu-selected').innerText += 'Burger, Fries';
    document.getElementById('num-persons').innerText += '3';
    document.getElementById('order-date').innerText += '2023-10-15';
    document.getElementById('order-time').innerText += '19:30';
    document.getElementById('order-price').innerText += '$25.99';
  }
  
  function generatePDF() {
    const reviewPage = document.body;
    const pdf = new jsPDF();
    pdf.html(reviewPage, {
      callback: function(pdf) {
        pdf.save('review.pdf');
      }
    });
  }
  
  fetchAndDisplayData();
  