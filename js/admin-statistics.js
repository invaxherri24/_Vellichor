const statisticsOverview = document.getElementById("statisticsOverview");
const activeMembersList = document.getElementById("activeMembersList");
const passiveMembersList = document.getElementById("passiveMembersList");

function renderOverview(data) {
  const mostBorrowedBook = data.mostBorrowedBook || "None";
  const mostRatedBook = data.mostRatedBook || "None";

  statisticsOverview.innerHTML = `
    <div class="stats-card">
      <h3>Total Members</h3>
      <p>${data.totalMembers || 0}</p>
    </div>

    <div class="stats-card">
      <h3>Most Borrowed Book</h3>
      <p>${mostBorrowedBook}</p>
    </div>

    <div class="stats-card">
      <h3>Most Rated Book</h3>
      <p>${mostRatedBook}</p>
    </div>

    <div class="stats-card">
      <h3>Total Books</h3>
      <p>${data.totalBooks || 0}</p>
    </div>
  `;
}

function renderMembers(container, members, emptyMessage) {
  container.innerHTML = "";

  if (!members.length) {
    container.innerHTML = `<p class="empty-text">${emptyMessage}</p>`;
    return;
  }

  members.forEach(member => {
    const memberCard = document.createElement("div");
    memberCard.className = "member-admin-card";

    memberCard.innerHTML = `
      <div class="member-admin-header">
        <h3>${member.name} ${member.surname}</h3>
        <span class="member-library-badge">Library ID: ${member.libraryId}</span>
      </div>

      <div class="member-admin-details">
        <p><strong>Email:</strong> ${member.email}</p>
        <p><strong>Username:</strong> ${member.username}</p>
        <p><strong>Active Borrowed Books:</strong> ${member.activeBorrowedCount}</p>
      </div>
    `;

    container.appendChild(memberCard);
  });
}

function loadStatistics() {
  fetch("../api/get-statistics.php")
    .then(response => response.json())
    .then(data => {
      renderOverview(data);

      renderMembers(
        activeMembersList,
        data.activeMembers || [],
        "No active members found."
      );

      renderMembers(
        passiveMembersList,
        data.passiveMembers || [],
        "No passive members found."
      );
    })
    .catch(() => {
      statisticsOverview.innerHTML = "<p class='message'>Could not load statistics.</p>";
      activeMembersList.innerHTML = "<p class='message'>Could not load statistics.</p>";
      passiveMembersList.innerHTML = "<p class='message'>Could not load statistics.</p>";
    });
}

loadStatistics();
