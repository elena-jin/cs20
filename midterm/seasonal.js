document.addEventListener('DOMContentLoaded', () => {
  const container = document.getElementById('drinks-container');

  // Directly use the JSON array (no fetch)
  const drinks = [
    { name: "Savannah Spice", type: "hot", price: "$5.25", image: "images/pumpkin.png" },
    { name: "Mask Off Matcha", type: "cold", price: "$5.00", image: "images/cider.png" },
    { name: "Hibiscus Heat", type: "hot", price: "$5.50", image: "images/maple.png" }
  ];

  // Render each drink card
  drinks.forEach(d => {
    const card = document.createElement('div');
    card.className = 'drink-card';
    card.innerHTML = `
      <img src="${d.image}" alt="${d.name}" class="drink-image">
      <h3>${d.name}</h3>
      <p>${d.price}</p>
      <p class="type">${d.type === 'hot' ? '🔥 Hot' : '🧊 Cold'}</p>
    `;
    container.appendChild(card);
  });
});
