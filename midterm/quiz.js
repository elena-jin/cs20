const drinks = {
  bold: { name: "Espresso Shot", desc: "You’re sharp, efficient, and ready to go!" },
  sweet: { name: "Iced Vanilla Latte", desc: "You love a balance of comfort and style." },
  chill: { name: "Cold Brew", desc: "You’re laid-back and cool without trying too hard." }
};

document.getElementById('drink-quiz').addEventListener('submit', function(e) {
  e.preventDefault();

  const morning = document.querySelector('input[name="morning"]:checked');
  const spot = document.getElementById('spot').value;
  const vibes = [...document.querySelectorAll('input[name="vibe"]:checked')];

  if (!morning || !spot || vibes.length === 0) {
    alert("Please answer all questions!");
    return;
  }

  const answers = [morning.value, spot, vibes[0].value];
  const type = mostCommon(answers);
  const result = drinks[type];

  /*dynamically updates the webpage to display the user’s personalized result */
  document.getElementById('result').innerHTML = `
    <h3>You’re a ${result.name}!</h3>
    <p>${result.desc}</p>  `;
});

// function mostCommon(arr) {
//   const freq = {};
//   arr.forEach(a => freq[a] = (freq[a] || 0) + 1);
//   return Object.keys(freq).reduce((a, b) => {
//   if (freq[a] > freq[b]) {
//     return a;
//   } else {
//     return b;
//   }
// });
// }
