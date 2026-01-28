// ===== MEMBER DIRECTORY FUNCTIONS =====

// Directory mock data (includes Who's In members + expired members)
const directoryMembers = [
    { name: "John Doe", status: "active", plan: "Premium", expiryDate: "2026-02-15", qrCode: "QR-JD-001", image: null },
    { name: "Alice Smith", status: "expired", plan: "Day Pass", expiryDate: "2026-01-10", qrCode: null, image: null },
    { name: "Michael Jordan", status: "active", plan: "Standard", expiryDate: "2026-03-01", qrCode: "QR-MJ-001", image: null },
    { name: "Sarah Connor", status: "active", plan: "Standard", expiryDate: "2026-02-20", qrCode: "QR-SC-001", image: null },
    { name: "Tony Stark", status: "expired", plan: "Premium", expiryDate: "2025-12-31", qrCode: null, image: null },
    { name: "Bruce Wayne", status: "active", plan: "Premium", expiryDate: "2026-04-15", qrCode: "QR-BW-001", image: null },
    { name: "Clark Kent", status: "active", plan: "Standard", expiryDate: "2026-02-28", qrCode: "QR-CK-001", image: null },
    { name: "Diana Prince", status: "expired", plan: "Standard", expiryDate: "2026-01-05", qrCode: null, image: null },
    { name: "Peter Parker", status: "active", plan: "Day Pass", expiryDate: "Today", qrCode: "QR-PP-001", image: null },
    { name: "Natasha Romanoff", status: "active", plan: "Premium", expiryDate: "2026-03-10", qrCode: "QR-NR-001", image: null },
    { name: "Steve Rogers", status: "active", plan: "Standard", expiryDate: "2026-02-25", qrCode: "QR-SR-001", image: null }
];

let currentDirectoryMember = null;

// Search for a member in the directory
function searchDirectoryMember() {
    const input = document.getElementById('dirSearchInput');
    const searchName = input.value.trim();

    if (!searchName) {
        return;
    }

    // Search for member (case-insensitive)
    const found = directoryMembers.find(m =>
        m.name.toLowerCase() === searchName.toLowerCase() ||
        m.name.toLowerCase().includes(searchName.toLowerCase())
    );

    if (found) {
        showDirectoryResult(found);
    } else {
        showDirectoryNotFound(searchName);
    }
}

// Display found member result
function showDirectoryResult(member) {
    currentDirectoryMember = member;

    // Hide search and not found states
    document.getElementById('dirSearchState').style.display = 'none';
    document.getElementById('dirNotFoundState').style.display = 'none';

    // Show result state
    document.getElementById('dirResultState').style.display = 'flex';

    // Populate member details
    document.getElementById('dirMemberName').textContent = member.name;
    document.getElementById('dirMemberExpiry').textContent = member.expiryDate;

    // Set status badge
    const statusBadge = document.getElementById('dirMemberStatus');
    statusBadge.textContent = member.status === 'active' ? 'Active' : 'Expired';
    statusBadge.className = 'dir-status-badge ' + member.status;

    // Update expiry label based on plan
    const expiryLabel = document.getElementById('dirExpiryLabel');
    if (member.plan === 'Day Pass') {
        expiryLabel.textContent = 'Valid Until';
    } else {
        expiryLabel.textContent = member.status === 'expired' ? 'Expired On' : 'Expires';
    }

    // Set action button
    const actionBtn = document.getElementById('dirActionBtn');
    if (member.status === 'active') {
        actionBtn.innerHTML = '<i class="fas fa-qrcode"></i> Show QR';
        actionBtn.className = 'dir-btn primary';
    } else {
        actionBtn.innerHTML = '<i class="fas fa-sync"></i> Renew';
        actionBtn.className = 'dir-btn renew';
    }

    // Set member photo (placeholder for now)
    const photo = document.getElementById('dirMemberPhoto');
    if (member.image) {
        photo.innerHTML = `<img src="${member.image}" alt="${member.name}">`;
    } else {
        photo.innerHTML = '<i class="fas fa-user"></i>';
    }
}

// Display not found state
function showDirectoryNotFound(searchName) {
    // Hide search and result states
    document.getElementById('dirSearchState').style.display = 'none';
    document.getElementById('dirResultState').style.display = 'none';

    // Show not found state
    document.getElementById('dirNotFoundState').style.display = 'flex';
    document.getElementById('dirSearchedName').textContent = searchName;
}

// Close result/not found and return to search
function closeDirectoryResult() {
    // Hide all states except search
    document.getElementById('dirResultState').style.display = 'none';
    document.getElementById('dirNotFoundState').style.display = 'none';

    // Show search state
    document.getElementById('dirSearchState').style.display = 'flex';

    // Clear search input
    document.getElementById('dirSearchInput').value = '';
    document.getElementById('dirSearchInput').focus();

    currentDirectoryMember = null;
}

// Handle action button click (Show QR or Renew)
function handleDirectoryAction() {
    if (!currentDirectoryMember) return;

    if (currentDirectoryMember.status === 'active') {
        // Show QR Code
        showDirQRCode(currentDirectoryMember);
    } else {
        // Redirect to renewal (switch to New Member panel with membership form)
        closeDirectoryResult();
        activateCell('bottom-left');
        showMembershipForm();

        // Optionally pre-fill the form with member's name
        document.getElementById('memberName').value = currentDirectoryMember.name;
    }
}

// Show QR Code Modal
function showDirQRCode(member) {
    const modal = document.getElementById('dirQRModal');
    const qrCanvas = document.getElementById('dirQRCodeCanvas');
    const memberName = document.getElementById('dirQRMemberName');

    memberName.textContent = member.name;

    // Generate QR code (using a simple text representation for now)
    qrCanvas.innerHTML = `
        <div style="width: 200px; height: 200px; background: #fff; border: 2px solid #000; display: flex; align-items: center; justify-content: center; font-family: monospace; font-size: 10px; padding: 10px; text-align: center; word-break: break-all;">
            ${member.qrCode || 'NO-QR-CODE'}
        </div>
    `;

    modal.classList.add('active');
}

// Close QR Modal
function closeDirQRModal() {
    document.getElementById('dirQRModal').classList.remove('active');
}

// Check In from Directory
function directoryCheckIn() {
    if (!currentDirectoryMember) return;

    const isDayPass = (currentDirectoryMember.plan === 'Day Pass');

    const memberData = {
        name: currentDirectoryMember.name,
        type: isDayPass ? 'day-pass' : 'membership',
        planName: currentDirectoryMember.plan,
        isDayPass: isDayPass
    };

    // Show prompt
    // Assuming showCheckinPrompt is globally available
    if (typeof showCheckinPrompt === 'function') {
        showCheckinPrompt(memberData, () => {
            // After check-in (Yes or No), close result and return to search
            closeDirectoryResult();
        });
    } else {
        console.error('showCheckinPrompt function not found!');
        alert('Check-in system not ready.');
    }
}

// Add Enter key support for search
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('dirSearchInput');
    if (searchInput) {
        searchInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                searchDirectoryMember();
            }
        });
    }
});
