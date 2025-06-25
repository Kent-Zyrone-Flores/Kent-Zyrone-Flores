const canvas = document.getElementById("background");
const ctx = canvas.getContext("2d");

function resizeCanvas() {
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;
}
resizeCanvas();
window.addEventListener("resize", resizeCanvas);

let stars = [];
const starCount = 120;
const connectionDistance = 100;

for (let i = 0; i < starCount; i++) {
  stars.push({
    x: Math.random() * canvas.width,
    y: Math.random() * canvas.height,
    radius: Math.random() * 1.5 + 0.5,
    alpha: Math.random(),
    dx: (Math.random() - 0.5) * 0.4,
    dy: (Math.random() - 0.5) * 0.4,
    twinkleSpeed: Math.random() * 0.02 + 0.005,
  });
}

function drawStarsAndLines() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);

  drawBigStars();

  ctx.clearRect(0, 0, canvas.width, canvas.height);

  for (let star of stars) {
    ctx.beginPath();
    ctx.arc(star.x, star.y, star.radius, 0, Math.PI * 2);
    ctx.fillStyle = `rgba(255, 255, 255, ${star.alpha})`;
    ctx.fill();
  }

  for (let i = 0; i < stars.length; i++) {
    for (let j = i + 1; j < stars.length; j++) {
      const a = stars[i];
      const b = stars[j];
      const dist = Math.hypot(a.x - b.x, a.y - b.y);

      if (dist < connectionDistance) {
        ctx.beginPath();
        ctx.moveTo(a.x, a.y);
        ctx.lineTo(b.x, b.y);
        ctx.strokeStyle = `rgba(255, 255, 255, ${
          1 - dist / connectionDistance
        })`;
        ctx.lineWidth = 0.5;
        ctx.stroke();
      }
    }
  }
}
function drawBigStars() {
  const centerX = canvas.width / 2;
  const baseY = canvas.height * 0.28; // Position above your name

  const starPositions = [
    { x: centerX - 100, y: baseY },
    { x: centerX, y: baseY - 30 },
    { x: centerX + 100, y: baseY },
  ];

  for (let pos of starPositions) {
    ctx.beginPath();
    ctx.arc(pos.x, pos.y, 12, 0, Math.PI * 2); // Bigger size: 12px radius
    ctx.fillStyle = "rgba(255, 255, 100, 0.9)";
    ctx.shadowColor = "rgba(255, 255, 255, 0.8)";
    ctx.shadowBlur = 15;
    ctx.fill();
    ctx.shadowBlur = 0;
  }
}

function animate() {
  for (let star of stars) {
    star.x += star.dx;
    star.y += star.dy;

    if (star.x < 0 || star.x > canvas.width) star.dx *= -1;
    if (star.y < 0 || star.y > canvas.height) star.dy *= -1;

    star.alpha += star.twinkleSpeed * (Math.random() > 0.5 ? 1 : -1);
    star.alpha = Math.max(0.2, Math.min(star.alpha, 1));
  }

  drawStarsAndLines();
  requestAnimationFrame(animate);
}
animate();
function drawGeometry() {
  ctx.strokeStyle = "rgba(255, 76, 96, 0.15)";
  ctx.lineWidth = 0.4;

  for (let i = 0; i < stars.length; i++) {
    for (let j = i + 1; j < stars.length; j++) {
      const dx = stars[i].x - stars[j].x;
      const dy = stars[i].y - stars[j].y;
      const dist = Math.sqrt(dx * dx + dy * dy);
      if (dist < 100) {
        ctx.beginPath();
        ctx.moveTo(stars[i].x, stars[i].y);
        ctx.lineTo(stars[j].x, stars[j].y);
        ctx.stroke();
      }
    }
  }
}

document.querySelectorAll(".nav-links a").forEach((link) => {
  link.addEventListener("click", (e) => {
    e.preventDefault();
    const targetId = link.getAttribute("href");
    const section = document.querySelector(targetId);
    if (section) {
      section.scrollIntoView({ behavior: "smooth", block: "start" });
    }
  });
});

const text = "Kent Zyrone Flores";
const typed = document.getElementById("typed-name");
let index = 0;
let typing = true;

function typeLoop() {
  if (typing) {
    if (index < text.length) {
      typed.textContent += text.charAt(index);
      index++;
      setTimeout(typeLoop, 120);
    } else {
      typing = false;
      setTimeout(typeLoop, 1000);
    }
  } else {
    if (index > 0) {
      typed.textContent = text.substring(0, index - 1);
      index--;
      setTimeout(typeLoop, 60);
    } else {
      typing = true;
      setTimeout(typeLoop, 500);
    }
  }
}
document.addEventListener("DOMContentLoaded", typeLoop);

document.querySelectorAll(".nav-links a").forEach((link) => {
  link.addEventListener("click", (e) => {
    e.preventDefault();
    const targetId = link.getAttribute("href");
    const section = document.querySelector(targetId);
    if (section) {
      section.scrollIntoView({ behavior: "smooth" });
    }
  });
});

function toggleMenu() {
  document.getElementById("navLinks").classList.toggle("active");
}

document.querySelectorAll(".nav-links a").forEach((link) => {
  link.addEventListener("click", (e) => {
    e.preventDefault();
    const target = document.querySelector(link.getAttribute("href"));
    if (target) {
      target.scrollIntoView({ behavior: "smooth" });
    }

    document.getElementById("navLinks").classList.remove("active");
  });
});
