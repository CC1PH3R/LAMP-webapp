// Fetch and update scoreboard every 5 seconds
function updateScoreboard() {
  fetch('/LAMP-webapp/api/scores.php')
    .then(response => response.json())
    .then(data => {
      const container = document.getElementById('scoreboard-content');
      if (data.error) {
        container.innerHTML = `<div class="alert alert-error">${data.error}</div>`;
        return;
      }

      // Build HTML table
      let html = `
        <table class="score-table">
          <thead>
            <tr>
              <th>Rank</th>
              <th>User</th>
              <th>Total Points</th>
            </tr>
          </thead>
          <tbody>
      `;

      data.data.forEach((user, index) => {
        html += `
          <tr class="${getRowClass(index)}">
            <td>${index + 1}</td>
            <td>${escapeHtml(user.user_name)}</td>
            <td>${user.total_points}</td>
          </tr>
        `;
      });

      html += `</tbody></table>`;
      container.innerHTML = html;
    })
    .catch(error => {
      console.error('Error:', error);
    });
}

// Highlight top 3 users
function getRowClass(rank) {
  if (rank === 0) return 'gold';
  if (rank === 1) return 'silver';
  if (rank === 2) return 'bronze';
  return '';
}

// Prevent XSS
function escapeHtml(str) {
  return str.replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
}

// Initial load + refresh every 5 seconds
updateScoreboard();
setInterval(updateScoreboard, 5000);