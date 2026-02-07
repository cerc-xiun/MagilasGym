// Demo Data
        let expenses = [
            { id: 1, category: 'Product Restock', amount: 850, desc: 'Protein bars & energy drinks', date: '2026-01-19', time: '2 hours ago' },
            { id: 2, category: 'Miscellaneous', amount: 350, desc: 'Cleaning supplies', date: '2026-01-19', time: '4 hours ago' },
            { id: 3, category: 'Electric Bill', amount: 4500, desc: 'January electricity bill', date: '2026-01-18', time: 'Yesterday' },
            { id: 4, category: 'Water Bill', amount: 1200, desc: 'January water bill', date: '2026-01-18', time: 'Yesterday' },
            { id: 5, category: 'Equipment Repair', amount: 2500, desc: 'Treadmill motor replacement', date: '2026-01-17', time: '2 days ago' },
            { id: 6, category: 'Product Restock', amount: 1800, desc: 'Towels and toiletries', date: '2026-01-16', time: '3 days ago' }
        ];

        let currentCategory = 'all';

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            // Set default date to today
            document.getElementById('expenseDate').valueAsDate = new Date();
            renderExpenses();
            updateStats();
        });

        function getCategoryIcon(category) {
            const icons = {
                'Electric Bill': 'fa-bolt',
                'Water Bill': 'fa-droplet',
                'Product Restock': 'fa-box',
                'Equipment Repair': 'fa-wrench',
                'Miscellaneous': 'fa-tag'
            };
            return icons[category] || 'fa-receipt';
        }

        function getCategoryColor(category) {
            const colors = {
                'Electric Bill': '#f59e0b',
                'Water Bill': '#3b82f6',
                'Product Restock': '#10b981',
                'Equipment Repair': '#ef4444',
                'Miscellaneous': '#8b5cf6'
            };
            return colors[category] || '#6b7280';
        }

        function renderExpenses() {
            const list = document.getElementById('expenseList');
            let filtered = expenses;

            if (currentCategory !== 'all') {
                filtered = expenses.filter(e => e.category === currentCategory);
            }

            list.innerHTML = filtered.map(exp => `
                <div class="expense-item">
                    <div class="expense-icon" style="background: ${getCategoryColor(exp.category)}20; color: ${getCategoryColor(exp.category)};">
                        <i class="fas ${getCategoryIcon(exp.category)}"></i>
                    </div>
                    <div class="expense-details">
                        <h4>${exp.category}</h4>
                        <p>${exp.desc}</p>
                        <p style="font-size: 11px; color: var(--text-dim); margin-top: 4px;">
                            <i class="fas fa-calendar"></i> ${new Date(exp.date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })} • ${exp.time}
                        </p>
                    </div>
                    <div class="expense-amount">₱${exp.amount.toLocaleString()}</div>
                    <div class="expense-actions">
                        <button class="btn-icon danger" onclick="deleteExpense(${exp.id})" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `).join('');

            if (filtered.length === 0) {
                list.innerHTML = '<div class="empty-state"><i class="fas fa-receipt"></i><p>No expenses found</p></div>';
            }
        }

        function updateStats() {
            const today = new Date().toISOString().split('T')[0];
            const todayExpenses = expenses.filter(e => e.date === today);
            const todayTotal = todayExpenses.reduce((sum, e) => sum + e.amount, 0);

            // Week calculation (last 7 days)
            const weekAgo = new Date();
            weekAgo.setDate(weekAgo.getDate() - 7);
            const weekExpenses = expenses.filter(e => new Date(e.date) >= weekAgo);
            const weekTotal = weekExpenses.reduce((sum, e) => sum + e.amount, 0);

            // Month calculation
            const monthTotal = expenses.reduce((sum, e) => sum + e.amount, 0);

            document.getElementById('todayTotal').textContent = '₱' + todayTotal.toLocaleString();
            document.getElementById('weekTotal').textContent = '₱' + weekTotal.toLocaleString();
            document.getElementById('monthTotal').textContent = '₱' + monthTotal.toLocaleString();
        }

        function filterExpenses() {
            currentCategory = document.getElementById('categoryFilter').value;
            renderExpenses();
        }

        function deleteExpense(id) {
            if (confirm('Are you sure you want to delete this expense?')) {
                expenses = expenses.filter(e => e.id !== id);
                renderExpenses();
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

        // Form handler
        document.getElementById('addExpenseForm').addEventListener('submit', e => {
            e.preventDefault();
            const category = document.getElementById('expenseCategory').value;
            const amount = parseFloat(document.getElementById('expenseAmount').value);
            const desc = document.getElementById('expenseDesc').value.trim() || category;
            const date = document.getElementById('expenseDate').value;

            if (category && amount > 0 && date) {
                expenses.unshift({
                    id: Date.now(),
                    category,
                    amount,
                    desc,
                    date,
                    time: 'Just now'
                });
                renderExpenses();
                updateStats();
                closeModal('addExpenseModal');
                e.target.reset();
                document.getElementById('expenseDate').valueAsDate = new Date();
            }
        });

        // Mobile menu
        document.getElementById('menuBtn').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('open');
        });
