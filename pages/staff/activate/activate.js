// Update payment amount when plan changes
        document.querySelectorAll('input[name="plan"]').forEach(radio => {
            radio.addEventListener('change', function () {
                const price = this.dataset.price;
                document.getElementById('paymentAmount').value = price;
            });
        });

        function confirmActivation() {
            const selectedPlan = document.querySelector('input[name="plan"]:checked');
            const paymentAmount = document.getElementById('paymentAmount').value;

            if (!selectedPlan) {
                alert('Please select a plan');
                return;
            }

            const planPrice = parseInt(selectedPlan.dataset.price);
            if (parseInt(paymentAmount) < planPrice) {
                alert('Payment amount is less than plan price');
                return;
            }

            // Demo confirmation
            alert(`Membership activated!\nPlan: ${selectedPlan.value}\nPayment: ₱${paymentAmount}`);
        }

        // Mobile menu
        document.getElementById('menuBtn').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('open');
        });
