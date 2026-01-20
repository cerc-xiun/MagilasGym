// Demo Data for Who's In
        let gymMembers = [
            { id: 101, name: 'Sarah Connor', initials: 'SC', plan: 'Monthly', time: '2 hours ago' },
            { id: 102, name: 'Mike Johnson', initials: 'MJ', plan: 'Day Pass', time: '1 hour ago' }
        ];

        document.addEventListener('DOMContentLoaded', () => {
            renderGymMembers();
        });

        function renderGymMembers() {
            const list = document.getElementById('gymMembersList');
            const label = document.getElementById('activeLabel');
            
            if (gymMembers.length === 0) {
                list.innerHTML = '<div class="empty-state" style="padding:20px;text-align:center;color:var(--text-muted)"><i class="fas fa-user-slash" style="font-size:24px;margin-bottom:8px"></i><p>No active members</p></div>';
                label.textContent = '0 Active';
                return;
            }

            list.innerHTML = gymMembers.map(m => `
                <div class="member-row">
                    <div class="member-initials">${m.initials}</div>
                    <div class="member-details">
                        <h5>${m.name}</h5>
                        <small>${m.plan} • ${m.time}</small>
                    </div>
                    <button onclick="removeMember(${m.id})" class="btn-deny" style="padding: 6px 12px; font-size: 12px;">
                        <i class="fas fa-sign-out-alt"></i> Exit
                    </button>
                </div>
            `).join('');
            
            label.textContent = `${gymMembers.length} Active`;
        }

        function removeMember(id) {
            if(confirm('Mark member as exited?')) {
                gymMembers = gymMembers.filter(m => m.id !== id);
                renderGymMembers();
            }
        }

        function openScanModal() {
            document.getElementById('scanModal').style.display = 'flex';
        }

        function closeScanModal() {
            document.getElementById('scanModal').style.display = 'none';
            // Optional: reset camera state if desired when closing modal
             document.getElementById('camera-placeholder').style.display = 'flex';
             document.getElementById('camera-active').style.display = 'none';
             resetScan();
        }

        function startCamera() {
            document.getElementById('camera-placeholder').style.display = 'none';
            document.getElementById('camera-active').style.display = 'block';
            document.getElementById('scanStatus').textContent = 'Scanning...';
            // Here you would also initialize the actual QR scanner library
        }

        function simulateScan() {
            startCamera(); // Ensure camera UI is active first
            setTimeout(() => {
                document.getElementById('no-scan').style.display = 'none';
                document.getElementById('scan-data').style.display = 'block';
                document.getElementById('scanStatus').textContent = 'Member Found';
                document.getElementById('scanStatus').className = 'status-badge success';
            }, 800); // Small delay to simulate finding
        }

        function allowEntry() {
            // Add Demo User
            const newMember = {
                id: Date.now(),
                name: 'John Doe',
                initials: 'JD',
                plan: 'Premium',
                time: 'Just now'
            };
            gymMembers.unshift(newMember);
            renderGymMembers();
            
            alert('Entry Allowed! Member added to active list.');
            resetScan();
            closeScanModal(); // Close modal after success
        }

        function denyEntry() {
            alert('Entry Denied.');
            resetScan();
        }

        function resetScan() {
            document.getElementById('no-scan').style.display = 'block';
            document.getElementById('scan-data').style.display = 'none';
            document.getElementById('scanStatus').textContent = 'Waiting...';
            document.getElementById('scanStatus').className = 'status-badge pending';
        }

        // Mobile menu
        document.getElementById('menuBtn').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('open');
        });
