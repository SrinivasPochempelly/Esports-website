// // Function to toggle between sections (e.g., Tournaments, Add Tournament)
// function showSection(sectionId) {
//     // Remove 'active' class from all tournament boxes and submenu items
//     const tournamentBoxes = document.querySelectorAll('.tournaments-box');
//     const submenuTabs = document.querySelectorAll('.submenu a');
    
//     tournamentBoxes.forEach(box => box.classList.remove('active'));
//     submenuTabs.forEach(tab => tab.classList.remove('active'));

//     // Add 'active' class to the selected section and its corresponding tab
//     const section = document.getElementById(sectionId);
//     const tab = document.getElementById(sectionId + '-tab');
    
//     section.classList.add('active');
//     tab.classList.add('active');
// }

// Function to toggle between the 'Your Tournaments' and 'Add Tournament' sections
function toggleTournamentSection(targetSection) {
    const addTournamentSection = document.getElementById('add-tournament');
    const yourTournamentsSection = document.getElementById('your-tournaments');
    const addMenu = document.querySelector('#add-menu a');
    const yourMenu = document.querySelector('#your-menu');

    if (targetSection === 'add-tournament') {
        yourTournamentsSection.style.display = 'none';
        addTournamentSection.style.display = 'block';
        addMenu.style.color = '#ffcc00';
        yourMenu.style.color = 'white';
    } else {
        addTournamentSection.style.display = 'none';
        yourTournamentsSection.style.display = 'block';
        yourMenu.style.color = '#ffcc00';
        addMenu.style.color = 'white';
    }
}


function showSection(sectionId) {
    // Hide all sections
    document.querySelectorAll('.tournaments-box').forEach(box => box.classList.remove('active'));

    // Highlight the selected tab
    document.querySelectorAll('.submenu a').forEach(tab => tab.classList.remove('active'));

    // Show the selected section and activate the tab
    document.getElementById(sectionId).classList.add('active');
    document.getElementById(sectionId + '-tab').classList.add('active');
}
