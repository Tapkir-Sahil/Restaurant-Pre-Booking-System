// script.js

const bookingData = [
    { customerName: 'xyz',menuItem: 'Item 1', type: 'Type A', price: '$10.00',quantity: '2', numPersons: 2, totalPrice: '$20.00' },
    { customerName: 'xyz1',menuItem: 'Item 2', type: 'Type B', price: '$15.00', quantity: '2',numPersons: 3, totalPrice: '$45.00' }
];

document.addEventListener('DOMContentLoaded', () => {
    const bookingTable = document.getElementById('booking-data');

    // Populate the table with data
    bookingData.forEach(data => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${data.customerName}</td>
            <td>${data.menuItem}</td>
            <td>${data.type}</td>
            <td>${data.quantity}</td>
            <td>${data.price}</td>
            <td>${data.numPersons}</td>
            <td>${data.totalPrice}</td>
        `;
        bookingTable.appendChild(row);
    });
});
