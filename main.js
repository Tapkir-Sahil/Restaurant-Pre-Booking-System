const hotelsData = [
    { name: 'Hotel A', type: 'veg', rating: 4.5 },
    { name: 'Hotel B', type:'non_veg', rating: 4.2 },
    { name: 'Hotel C', type: 'veg', rating: 4.7 }
  ];
  
  function fetchHotels() {
    const hotelTableBody = document.querySelector('#hotel-table tbody');
    hotelTableBody.innerHTML = ''; // Clear existing content
  
    hotelsData.forEach((hotel, index) => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${hotel.name}</td>
        <td>${hotel.type}</td>
        <td>${hotel.rating}</td>
        <td><input type="checkbox" class="hotel-checkbox" value="${index}"></td>
      `;
      hotelTableBody.appendChild(tr);
    });
  }
  
  function bookSelectedHotels() {
    const checkboxes = document.querySelectorAll('.hotel-checkbox:checked');
    const selectedHotels = Array.from(checkboxes).map(checkbox => hotelsData[checkbox.value].name);
    alert('Selected Hotels: ' + selectedHotels.join(', '));
  }
  