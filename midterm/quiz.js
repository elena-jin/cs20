const drinks = {
  bold: { name: "Espresso Shot", desc: "You’re sharp, efficient, and ready to go!" },
  sweet: { name: "Iced Vanilla Latte", desc: "You love a balance of comfort and style." },
  chill: { name: "Cold Brew", desc: "You’re laid-back and cool without trying too hard." }
};

document.getElementById('drink-quiz').addEventListener('submit', function(e) {
  e.preventDefault();

  // Validate form
  const morning = document.querySelector('input[name="morning"]:checked');
  const spot = document.getElementById('spot').value;
  const vibes = [...document.querySelectorAll('input[name="vibe"]:checked')];

  if (!morning || !spot || vibes.length === 0) {
    alert("Please answer all questions!");
    return;
  }

  // Calculate personality type
  const answers = [morning.value, spot, vibes[0].value];
  const type = mostCommon(answers);
  const result = drinks[type];

  document.getElementById('result').innerHTML = `
    <h3>You’re a ${result.name}!</h3>
    <p>${result.desc}</p>
    <img src="images/${type}.png" alt="${result.name}" style="max-width:200px;">
  `;
});

function mostCommon(arr) {
  const freq = {};
  arr.forEach(a => freq[a] = (freq[a] || 0) + 1);
  return Object.keys(freq).reduce((a, b) => freq[a] > freq[b] ? a : b);
}
