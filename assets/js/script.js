// Function to toggle the sidebar visibility
function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  const hamburger = document.querySelector('.hamburger-menu');
  
  if (sidebar && hamburger) {
      // Toggle the open class on the sidebar and rotate class on the hamburger icon
      sidebar.classList.toggle('open');
      hamburger.classList.toggle('rotate');
  } else {
      console.error("Sidebar or hamburger menu element not found.");
  }
}

// Add event listener to the hamburger menu to toggle the sidebar
document.addEventListener('DOMContentLoaded', () => {
  const hamburger = document.querySelector('.hamburger-menu');
  
  if (hamburger) {
      hamburger.addEventListener('click', toggleSidebar);
  } else {
      console.error("Hamburger menu element not found.");
  }
});
