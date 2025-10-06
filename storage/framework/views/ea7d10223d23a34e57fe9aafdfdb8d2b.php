<?php $__env->startSection('title', 'Reports - Staff Portal'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Reports Dashboard</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Generate and view system reports and analytics</p>
            </div>
            <div>
                <a href="<?php echo e(route('transcript.staff.dashboard')); ?>" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <?php if(isset($stats['applications'])): ?>
        <!-- Applications Stats -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200/50 dark:border-gray-700/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Applications</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e(number_format($stats['applications']['total'])); ?></p>
                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1"><?php echo e($stats['applications']['this_month']); ?> this month</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-alt text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if(isset($stats['payments'])): ?>
        <!-- Payments Stats -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200/50 dark:border-gray-700/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">₦<?php echo e(number_format($stats['payments']['total_revenue'], 2)); ?></p>
                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1"><?php echo e($stats['payments']['this_month']); ?> payments this month</p>
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-credit-card text-green-600 dark:text-green-400 text-xl"></i>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if(isset($stats['staff'])): ?>
        <!-- Staff Stats -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200/50 dark:border-gray-700/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Active Staff</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e($stats['staff']['active']); ?></p>
                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1"><?php echo e($stats['staff']['with_roles']); ?> with roles</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-purple-600 dark:text-purple-400 text-xl"></i>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Report Generation -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200/50 dark:border-gray-700/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Generate Report</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">
                        <i class="fas fa-chart-line text-orange-600 dark:text-orange-400"></i>
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">Custom reports</p>
                </div>
                <button onclick="openReportModal()" class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center hover:bg-orange-200 dark:hover:bg-orange-900/30 transition-colors">
                    <i class="fas fa-plus text-orange-600 dark:text-orange-400 text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Report Generation Form -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Generate Custom Report</h2>
        
        <form id="reportForm" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="report_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Report Type</label>
                <select id="report_type" name="report_type" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white">
                    <option value="">Select Report Type</option>
                    <?php if(auth('transcript_staff')->user()->hasPermission('view_transcript_applications')): ?>
                    <option value="applications">Applications Report</option>
                    <?php endif; ?>
                    <?php if(auth('transcript_staff')->user()->hasPermission('view_transcript_payments')): ?>
                    <option value="payments">Payments Report</option>
                    <?php endif; ?>
                    <?php if(auth('transcript_staff')->user()->hasPermission('manage_transcript_staff')): ?>
                    <option value="staff">Staff Report</option>
                    <?php endif; ?>
                    <option value="summary">Summary Report</option>
                </select>
            </div>

            <div>
                <label for="date_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">From Date</label>
                <input type="date" id="date_from" name="date_from" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white">
            </div>

            <div>
                <label for="date_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">To Date</label>
                <input type="date" id="date_to" name="date_to" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white">
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-chart-bar mr-2"></i>
                    Generate Report
                </button>
            </div>
        </form>
    </div>

    <!-- Report Results -->
    <div id="reportResults" class="hidden bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Report Results</h2>
            <button onclick="exportReport()" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200 flex items-center">
                <i class="fas fa-download mr-2"></i>
                Export CSV
            </button>
        </div>
        
        <div id="reportContent">
            <!-- Report content will be loaded here -->
        </div>
    </div>
</div>

<!-- Report Modal -->
<div id="reportModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 w-full max-w-md mx-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Quick Report</h3>
            <button onclick="closeReportModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="space-y-3">
            <?php if(auth('transcript_staff')->user()->hasPermission('view_transcript_applications')): ?>
            <button onclick="generateQuickReport('applications')" class="w-full p-3 text-left bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg transition-colors">
                <i class="fas fa-file-alt text-blue-600 dark:text-blue-400 mr-3"></i>
                Applications Report
            </button>
            <?php endif; ?>
            
            <?php if(auth('transcript_staff')->user()->hasPermission('view_transcript_payments')): ?>
            <button onclick="generateQuickReport('payments')" class="w-full p-3 text-left bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg transition-colors">
                <i class="fas fa-credit-card text-green-600 dark:text-green-400 mr-3"></i>
                Payments Report
            </button>
            <?php endif; ?>
            
            <?php if(auth('transcript_staff')->user()->hasPermission('manage_transcript_staff')): ?>
            <button onclick="generateQuickReport('staff')" class="w-full p-3 text-left bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg transition-colors">
                <i class="fas fa-users text-purple-600 dark:text-purple-400 mr-3"></i>
                Staff Report
            </button>
            <?php endif; ?>
            
            <button onclick="generateQuickReport('summary')" class="w-full p-3 text-left bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg transition-colors">
                <i class="fas fa-chart-line text-orange-600 dark:text-orange-400 mr-3"></i>
                Summary Report
            </button>
        </div>
    </div>
</div>

<script>
let currentReportData = null;

// Form submission
document.getElementById('reportForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const reportType = formData.get('report_type');
    
    if (!reportType) {
        alert('Please select a report type');
        return;
    }
    
    generateReport(reportType, formData.get('date_from'), formData.get('date_to'));
});

// Generate report function
function generateReport(type, dateFrom = null, dateTo = null) {
    const button = document.querySelector('#reportForm button[type="submit"]');
    const originalText = button.innerHTML;
    
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Generating...';
    button.disabled = true;
    
    const params = new URLSearchParams({
        report_type: type,
        ...(dateFrom && { date_from: dateFrom }),
        ...(dateTo && { date_to: dateTo })
    });
    
    fetch(`<?php echo e(route('transcript.staff.reports.generate')); ?>?${params}`)
        .then(response => response.json())
        .then(data => {
            currentReportData = data;
            displayReport(data);
            document.getElementById('reportResults').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error generating report. Please try again.');
        })
        .finally(() => {
            button.innerHTML = originalText;
            button.disabled = false;
        });
}

// Display report function
function displayReport(data) {
    const content = document.getElementById('reportContent');
    let html = '';
    
    if (data.type === 'summary') {
        html = generateSummaryHTML(data.summary);
    } else {
        html = generateTableHTML(data);
    }
    
    content.innerHTML = html;
}

// Generate summary HTML
function generateSummaryHTML(summary) {
    return `
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                <h3 class="font-semibold text-blue-900 dark:text-blue-100 mb-2">Applications</h3>
                <div class="space-y-1 text-sm">
                    <div class="flex justify-between">
                        <span>Total:</span>
                        <span class="font-medium">${summary.applications.total}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Pending:</span>
                        <span class="font-medium">${summary.applications.pending}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Completed:</span>
                        <span class="font-medium">${summary.applications.completed}</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                <h3 class="font-semibold text-green-900 dark:text-green-100 mb-2">Payments</h3>
                <div class="space-y-1 text-sm">
                    <div class="flex justify-between">
                        <span>Total:</span>
                        <span class="font-medium">${summary.payments.total}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Success:</span>
                        <span class="font-medium">${summary.payments.success}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Revenue:</span>
                        <span class="font-medium">₦${Number(summary.payments.total_revenue).toLocaleString()}</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                <h3 class="font-semibold text-purple-900 dark:text-purple-100 mb-2">Staff</h3>
                <div class="space-y-1 text-sm">
                    <div class="flex justify-between">
                        <span>Total:</span>
                        <span class="font-medium">${summary.staff.total}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Active:</span>
                        <span class="font-medium">${summary.staff.active}</span>
                    </div>
                </div>
            </div>
        </div>
    `;
}

// Generate table HTML
function generateTableHTML(data) {
    if (!data.data || data.data.length === 0) {
        return '<p class="text-gray-500 text-center py-8">No data found for the selected criteria.</p>';
    }
    
    let html = `<div class="overflow-x-auto">
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-700">`;
    
    // Generate headers based on report type
    if (data.type === 'applications') {
        html += `
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-white">ID</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-white">Student</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-white">Type</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-white">Status</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-white">Date</th>
        `;
    } else if (data.type === 'payments') {
        html += `
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-white">ID</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-white">Amount</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-white">Status</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-white">Date</th>
        `;
    } else if (data.type === 'staff') {
        html += `
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-white">Name</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-white">Email</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-white">Department</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-white">Roles</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-white">Status</th>
        `;
    }
    
    html += `</tr></thead><tbody>`;
    
    // Generate rows
    data.data.forEach(item => {
        html += '<tr class="border-b border-gray-200 dark:border-gray-700">';
        
        if (data.type === 'applications') {
            html += `
                <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">${item.id}</td>
                <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">${item.student ? item.student.fname + ' ' + item.student.lname : 'N/A'}</td>
                <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">${item.application_type || 'N/A'}</td>
                <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">${item.application_status || 'N/A'}</td>
                <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">${new Date(item.created_at).toLocaleDateString()}</td>
            `;
        } else if (data.type === 'payments') {
            html += `
                <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">${item.id}</td>
                <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">₦${Number(item.amount).toLocaleString()}</td>
                <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">${item.transaction_status || 'N/A'}</td>
                <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">${new Date(item.created_at).toLocaleDateString()}</td>
            `;
        } else if (data.type === 'staff') {
            const roles = item.active_roles ? item.active_roles.map(role => role.display_name).join(', ') : 'No roles';
            html += `
                <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">${item.fname} ${item.lname}</td>
                <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">${item.email}</td>
                <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">${item.department || 'N/A'}</td>
                <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">${roles}</td>
                <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">${item.status == 1 ? 'Active' : 'Inactive'}</td>
            `;
        }
        
        html += '</tr>';
    });
    
    html += '</tbody></table></div>';
    
    return html;
}

// Modal functions
function openReportModal() {
    document.getElementById('reportModal').classList.remove('hidden');
}

function closeReportModal() {
    document.getElementById('reportModal').classList.add('hidden');
}

function generateQuickReport(type) {
    closeReportModal();
    generateReport(type);
}

// Export function
function exportReport() {
    if (!currentReportData) {
        alert('No report data to export');
        return;
    }
    
    let csv = '';
    
    if (currentReportData.type === 'summary') {
        // Export summary as CSV
        csv = 'Category,Metric,Value\n';
        const summary = currentReportData.summary;
        
        Object.keys(summary).forEach(category => {
            if (typeof summary[category] === 'object') {
                Object.keys(summary[category]).forEach(metric => {
                    csv += `${category},${metric},${summary[category][metric]}\n`;
                });
            }
        });
    } else {
        // Export table data as CSV
        if (currentReportData.type === 'applications') {
            csv = 'ID,Student,Type,Status,Date\n';
            currentReportData.data.forEach(item => {
                const student = item.student ? `${item.student.fname} ${item.student.lname}` : 'N/A';
                csv += `${item.id},"${student}","${item.application_type || 'N/A'}","${item.application_status || 'N/A'}","${new Date(item.created_at).toLocaleDateString()}"\n`;
            });
        } else if (currentReportData.type === 'payments') {
            csv = 'ID,Amount,Status,Date\n';
            currentReportData.data.forEach(item => {
                csv += `${item.id},${item.amount},"${item.transaction_status || 'N/A'}","${new Date(item.created_at).toLocaleDateString()}"\n`;
            });
        } else if (currentReportData.type === 'staff') {
            csv = 'Name,Email,Department,Roles,Status\n';
            currentReportData.data.forEach(item => {
                const roles = item.active_roles ? item.active_roles.map(role => role.display_name).join('; ') : 'No roles';
                csv += `"${item.fname} ${item.lname}","${item.email}","${item.department || 'N/A'}","${roles}","${item.status == 1 ? 'Active' : 'Inactive'}"\n`;
            });
        }
    }
    
    // Download CSV
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `${currentReportData.type}_report_${new Date().toISOString().split('T')[0]}.csv`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
}

// Close modal when clicking outside
document.getElementById('reportModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeReportModal();
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.staff', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Veritas ICT\Downloads\trans\transcript-system\resources\views/transcript/staff/reports/index.blade.php ENDPATH**/ ?>