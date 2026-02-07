/**
 * UNIFIED RECEIPT GENERATOR
 * Single source of truth for all system receipts.
 */

function generateUnifiedReceipt(data) {
    const {
        memberName,
        memberId,
        transactionName, // e.g., "Student Monthly (1 month)"
        amount,
        paymentMethod,
        date, // Optional: defaults to now
        onDone
    } = data;

    // Remove existing modal if any
    const existingModal = document.getElementById('unifiedReceiptOverlay');
    if (existingModal) {
        existingModal.remove();
    }

    // Format Date
    const now = date ? new Date(date) : new Date();
    const dateStr = now.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    const timeStr = now.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });

    // Format Payment Method
    const paymentMap = {
        'cash': 'Cash',
        'gcash': 'GCash',
        'bank': 'Bank Transfer',
        'card': 'Credit/Debit Card'
    };
    const paymentDisplay = paymentMap[paymentMethod.toLowerCase()] || paymentMethod;

    // Create Modal DOM
    const overlay = document.createElement('div');
    overlay.id = 'unifiedReceiptOverlay';
    overlay.className = 'unified-receipt-overlay';

    overlay.innerHTML = `
        <div class="unified-receipt-card">
            <!-- Header -->
            <div class="unified-receipt-header">
                <div class="unified-receipt-icon">
                    <i class="fas fa-check"></i>
                </div>
                <h2>Registration Successful</h2>
                <p>Welcome to Magilas Gym</p>
            </div>

            <!-- Body -->
            <div class="unified-receipt-body">
                
                <!-- Member Info -->
                <div class="unified-row" style="margin-bottom: 2px;">
                    <span class="unified-label">MEMBER INFORMATION</span>
                    <span class="unified-value large">${memberName}</span>
                </div>
                <div class="unified-row">
                    <span></span> <!-- Spacer -->
                    <span class="unified-subtext">${memberId}</span>
                </div>

                <hr class="unified-divider">

                <!-- Transaction Info -->
                <div class="unified-row">
                    <span class="unified-label">TRANSACTION DETAILS</span>
                </div>
                <div class="unified-row">
                    <span class="unified-subtext" style="color: #4b5563; font-size: 14px;">${transactionName}</span>
                    <span class="unified-value">₱${amount.toLocaleString()}</span>
                </div>

                <hr class="unified-divider">

                <!-- QR Code (Conditional) -->
                ${data.qrId ? `
                <div class="unified-qr-section">
                    <span class="unified-label">MEMBER QR CODE</span>
                    <div class="unified-qr-container" id="receiptQrContainer">
                         <div class="qr-id-display-receipt">
                            <span class="qr-id-label">Assigned QR ID</span>
                            <strong class="qr-id-value">${data.qrId}</strong>
                            <span class="qr-id-hint">Code on Card</span>
                        </div>
                    </div>
                    <span class="unified-subtext">Scan this code for gym access</span>
                </div>
                <hr class="unified-divider">
                ` : ''}

                <!-- Payment Details -->
                <div class="unified-row">
                    <span class="unified-subtext" style="color: #6b7280;">Payment Method</span>
                    <span class="unified-value">${paymentDisplay}</span>
                </div>
                <div class="unified-row">
                    <span class="unified-subtext" style="color: #6b7280;">Date & Time</span>
                    <span class="unified-value">${dateStr} ${timeStr}</span>
                </div>

                <!-- Total -->
                <div class="unified-total-box">
                    <span class="unified-total-label">Total Paid</span>
                    <span class="unified-total-amount">₱${amount.toLocaleString()}</span>
                </div>
            </div>

            <!-- Footer -->
            <div class="unified-receipt-footer">
                <button class="unified-btn print" onclick="window.print()">
                    <i class="fas fa-print"></i> Print
                </button>
                <button class="unified-btn done" id="unifiedReceiptDoneBtn">
                    Done
                </button>
            </div>
        </div>
    `;

    document.body.appendChild(overlay);

    // 4. Generate QR Code (NOW: Display QR ID Text)
    const qrContainer = document.getElementById('receiptQrContainer');
    if (qrContainer) {
        qrContainer.innerHTML = ''; // Clear previous

        if (data.qrId) {
            // Display QR ID Text
            qrContainer.innerHTML = `
                <div class="qr-id-display-receipt">
                    <span class="qr-id-label">Assigned QR ID</span>
                    <strong class="qr-id-value">${data.qrId}</strong>
                    <span class="qr-id-hint">Code on Card</span>
                </div>
            `;
        } else {
            // Fallback if no QR ID (e.g., legacy or error)
            qrContainer.innerHTML = `
                <div class="qr-placeholder">
                    <span>No QR ID</span>
                </div>
            `;
        }
    }

    // Event Listeners
    const doneBtn = document.getElementById('unifiedReceiptDoneBtn');
    doneBtn.onclick = () => {
        overlay.classList.remove('active');
        setTimeout(() => {
            overlay.remove();
            if (onDone) onDone();
        }, 200);
    };

    // Show with animation
    requestAnimationFrame(() => {
        overlay.classList.add('active');
    });
}
