document.getElementById("messageForm").addEventListener("submit", function(event) {
  event.preventDefault();

  const fullName = document.getElementById("fullName").value;
  const message = document.getElementById("message").value;

  const formData = new FormData();
  formData.append("fullName", fullName);
  formData.append("message", message);

  fetch("save_message.php", {
      method: "POST",
      body: formData
  })
  .then(response => response.json())
  .then(data => {
      // Полученный ответ содержит ранее переданные сообщения в формате JSON. Добавим их в таблицу на странице
      const messageTable = document.getElementById("messageTable").getElementsByTagName("tbody")[0];
      data.forEach(entry => {
          const row = document.createElement("tr");
          const nameCell = document.createElement("td");
          const messageCell = document.createElement("td");

          nameCell.textContent = entry.user_name;
          messageCell.textContent = entry.msg_text;

          row.appendChild(nameCell);
          row.appendChild(messageCell);

          messageTable.appendChild(row);
      });
  })
  .catch(error => console.error("Ошибка:", error));
});
