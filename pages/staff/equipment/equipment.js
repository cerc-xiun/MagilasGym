// Demo Data
        let equipment = [
            { id: 1, name: 'Treadmill #1', category: 'Cardio', location: 'Cardio Zone', status: 'operational', issue: null },
            { id: 2, name: 'Treadmill #2', category: 'Cardio', location: 'Cardio Zone', status: 'issue', issue: { priority: 'medium', desc: 'Belt slipping during high-speed runs', time: '1 hour ago' } },
            { id: 3, name: 'Treadmill #3', category: 'Cardio', location: 'Cardio Zone', status: 'operational', issue: null },
            { id: 4, name: 'Bench Press', category: 'Strength', location: 'Free Weights', status: 'operational', issue: null },
            { id: 5, name: 'Incline Bench', category: 'Strength', location: 'Free Weights', status: 'operational', issue: null },
            { id: 6, name: 'Cable Machine', category: 'Machines', location: 'Machine Area', status: 'issue', issue: { priority: 'high', desc: 'Frayed cable - safety concern!', time: '3 hours ago' } },
            { id: 7, name: 'Leg Press', category: 'Machines', location: 'Machine Area', status: 'operational', issue: null },
            { id: 8, name: 'Rowing Machine', category: 'Cardio', location: 'Cardio Zone', status: 'operational', issue: null },
            { id: 9, name: 'Squat Rack', category: 'Strength', location: 'Free Weights', status: 'operational', issue: null }
        ];

        let currentFilter = 'all';

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            renderEquipment();
            updateStats();
        });

        function renderEquipment() {
            const list = document.getElementById('equipmentList');
            let filtered = equipment;

            if (currentFilter === 'operational') {
                filtered = equipment.filter(e => e.status === 'operational');
            } else if (currentFilter === 'issues') {
                filtered = equipment.filter(e => e.status === 'issue');
            }

            list.innerHTML = filtered.map(eq => `
                <div class="equipment-item">
                    <div class="equipment-icon">
                        <i class="fas fa-dumbbell"></i>
                    </div>
                    <div class="equipment-details">
                        <h4>${eq.name}</h4>
                        <p>${eq.category} • ${eq.location}</p>
                        ${eq.issue ? `<p style="color: var(--danger); margin-top: 6px;"><i class="fas fa-exclamation-triangle"></i> ${eq.issue.desc}</p>` : ''}
                    </div>
                    <div class="equipment-status">
                        <span class="status-badge ${eq.status === 'operational' ? 'success' : 'danger'}">
                            ${eq.status === 'operational' ? 'Operational' : 'Has Issue'}
                        </span>
                    </div>
                    <div class="equipment-actions">
                        ${eq.status === 'operational' ? `
                            <button class="btn-icon" onclick="openReportModal(${eq.id})" title="Report Issue">
                                <i class="fas fa-exclamation-triangle"></i>
                            </button>
                        ` : `
                            <button class="btn-icon" onclick="resolveIssue(${eq.id})" title="Mark Resolved" style="color: var(--success);">
                                <i class="fas fa-check"></i>
                            </button>
                        `}
                        <button class="btn-icon danger" onclick="deleteEquipment(${eq.id})" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `).join('');
        }

        function updateStats() {
            const total = equipment.length;
            const operational = equipment.filter(e => e.status === 'operational').length;
            const issues = equipment.filter(e => e.status === 'issue').length;

            document.getElementById('totalEquipment').textContent = total;
            document.getElementById('operationalCount').textContent = operational;
            document.getElementById('issuesCount').textContent = issues;
            document.getElementById('issuesBadge').textContent = issues;
        }

        function filterEquipment(filter) {
            currentFilter = filter;
            renderEquipment();
        }

        function openReportModal(id) {
            const eq = equipment.find(e => e.id === id);
            if (eq) {
                document.getElementById('reportEquipId').value = id;
                document.getElementById('reportEquipName').textContent = eq.name;
                openModal('reportModal');
            }
        }

        function resolveIssue(id) {
            const eq = equipment.find(e => e.id === id);
            if (eq) {
                eq.status = 'operational';
                eq.issue = null;
                renderEquipment();
                updateStats();
            }
        }

        function deleteEquipment(id) {
            if (confirm('Are you sure you want to delete this equipment?')) {
                equipment = equipment.filter(e => e.id !== id);
                renderEquipment();
                updateStats();
            }
        }

        // Modal functions
        function openModal(id) {
            document.getElementById(id).classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('show');
            document.body.style.overflow = '';
        }

        document.querySelectorAll('.modal-backdrop').forEach(modal => {
            modal.addEventListener('click', e => { if (e.target === modal) closeModal(modal.id); });
        });

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') document.querySelectorAll('.modal-backdrop.show').forEach(m => closeModal(m.id));
        });

        // Form handlers
        document.getElementById('addEquipForm').addEventListener('submit', e => {
            e.preventDefault();
            const name = document.getElementById('equipName').value.trim();
            const category = document.getElementById('equipCategory').value;
            const location = document.getElementById('equipLocation').value.trim() || 'Main Floor';

            if (name && category) {
                equipment.push({
                    id: Date.now(),
                    name,
                    category,
                    location,
                    status: 'operational',
                    issue: null
                });
                renderEquipment();
                updateStats();
                closeModal('addEquipModal');
                e.target.reset();
            }
        });

        document.getElementById('reportForm').addEventListener('submit', e => {
            e.preventDefault();
            const id = parseInt(document.getElementById('reportEquipId').value);
            const priority = document.getElementById('reportPriority').value;
            const desc = document.getElementById('reportDesc').value.trim();

            const eq = equipment.find(e => e.id === id);
            if (eq && desc) {
                eq.status = 'issue';
                eq.issue = { priority, desc, time: 'Just now' };
                renderEquipment();
                updateStats();
                closeModal('reportModal');
                e.target.reset();
            }
        });

        // Mobile menu
        document.getElementById('menuBtn').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('open');
        });
