document.addEventListener('DOMContentLoaded', () => {
  const container = document.getElementById('drinks-container');

  // use json arr
  const drinks = [
    { name: "Savannah Spice", type: "hot", price: "$5.25"},
    { name: "Mask Off Matcha", type: "cold", price: "$5.00"},
    { name: "Hibiscus Heat", type: "hot", price: "$5.50"}
  ];


// drink card
  drinks.forEach(d => {
    const card = document.createElement('div');
    card.className = 'drink-card';
    card.innerHTML = `
      <h3>${d.name}</h3>
      <p>${d.price}</p>
      <p class="type">${d.type === 'hot' ? '🔥 Hot' : '🧊 Cold'}</p>
    `;
    container.appendChild(card);
  });
});
