const snowContainer = document.querySelector(".snow-container");
const snowflakes = 1000; // Number of snowflakes

function createSnowflake() {
    const snowflake = document.createElement("div");
    snowflake.classList.add("snow");


    snowflake.style.left = Math.random() * 100 + "vw";
    snowflake.style.width = Math.random() * 5 + 2 + "px"; // Random size
    snowflake.style.height = snowflake.style.width; // Keep circular


    snowflake.style.animationDuration = Math.random() * 3 + 2 + "s"; // 2s to 5s


    snowContainer.appendChild(snowflake);


    setTimeout(() => {
        snowflake.remove();
    }, 5000); // Snowflake lifetime
}


setInterval(createSnowflake, 200); // Create snowflake every 200ms
