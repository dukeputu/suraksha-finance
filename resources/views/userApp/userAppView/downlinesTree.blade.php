@extends('userApp.layouts.userAppLayout')
@section('title', 'Dashboard')

@section('content')



    <!-- App Header -->
    <div class="appHeader">
        <div class="left">
            <a href="{{ route('dashboard.app') }}" class="headerButton ">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Down Lines
        </div>

    </div>
    <!-- * App Header -->


    <!-- App Capsule -->
    <div id="appCapsule">

        <!-- Transactions -->
        <div class="section mt-2">

            <div class="mlm-tree">
                <ul>
                    <li>
                        {{-- <div class="node toggle open">➖ 👑 Root</div> --}}
                        {!! $treeHtml !!}

                    </li>
                </ul>
            </div>



        </div>
        <!-- * Transactions -->
    </div>
    <!-- * App Capsule -->




    
<style>
    .mlm-tree {
        padding: 20px;
        font-family: 'Segoe UI', sans-serif;
        color: #444;
    }

    .mlm-tree ul {
        padding-left: 30px;
        border-left: 2px dashed #ccc;
        margin-left: 15px;
    }

    .mlm-tree li {
        list-style: none;
        margin: 10px 0;
        position: relative;
    }

    .mlm-tree .node {
        background: #f8f9fa;
        padding: 8px 12px;
        border-radius: 6px;
        border: 1px solid #ccc;
        display: inline-block;
        font-size: 14px;
        cursor: pointer;
        transition: 0.3s ease;
        position: relative;
    }

    .mlm-tree .node:hover {
        background: #e0f7fa;
        border-color: #17a2b8;
        font-weight: bold;
    }

    .children {
        display: block;
    }

    /* collapsed hidden */
    .node:not(.open)+.children {
        display: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.node.toggle').forEach(function(node) {
            node.addEventListener('click', function() {
                node.classList.toggle('open');
                const children = node.nextElementSibling;
                if (children && children.classList.contains('children')) {
                    children.style.display = node.classList.contains('open') ? 'block' : 'none';
                }

                // Toggle plus/minus icon
                node.innerHTML = node.innerHTML.replace(/^➕/, '➖');
                if (!node.classList.contains('open')) {
                    node.innerHTML = node.innerHTML.replace(/^➖/, '➕');
                }
            });
        });
    });
</script>

    <!-- Modal Basic -->
<div class="modal fade modalbox" id="ModalBasic" tabindex="-1" role="dialog" data-bs-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">
          Name: <span id="modalUserName">-</span> 
         &nbsp; &nbsp;  &nbsp; Phone ID: <span id="modalUserPhone">-</span> 
          &nbsp; &nbsp;  &nbsp; Child Count: <span id="modalChildCount">-</span>
        </h5>
        <a href="#" data-bs-dismiss="modal">Close</a>
      </div>

      <div class="modal-body">
        <div class="table-responsive">
          <table class="table bg-primary">
            <thead>
              <tr>
                <th>Down Line Name</th>
                <th>Phone</th>
                <th class="text-end">Package Amount</th>
              </tr>
            </thead>
            <tbody id="downlineTableBody">
              <!-- Populated by JS -->
            </tbody>
            <tfoot>
              <tr>
                <td colspan="2" class="text-end"><strong>Total Income:</strong></td>
                <td class="text-end"><strong id="totalIncome">₹0.00</strong></td>
              </tr>
              <tr>
                <td colspan="2" class="text-end"><strong>1% Income:</strong></td>
                <td class="text-end"><strong id="totalIncomeOnePer">₹0.00</strong></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>

{{-- 
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('ModalBasic');
    const tableBody = document.getElementById('downlineTableBody');
    const totalIncomeField = document.getElementById('totalIncome');
    const totalIncomeOnePer = document.getElementById('totalIncomeOnePer');
    const modalUserName = document.getElementById('modalUserName');
    const modalUserPhone = document.getElementById('modalUserPhone');
    const modalChildCount = document.getElementById('modalChildCount');

    document.querySelectorAll('.openIncomeModal').forEach(btn => {
        btn.addEventListener('click', function () {
            const userName = this.getAttribute('data-user-name');
            const userPhone = this.getAttribute('data-user-phone');
            const userId = this.getAttribute('data-user-id');

            modalUserName.textContent = userName;
            modalUserPhone.textContent = userPhone;

            // Clear previous data
            tableBody.innerHTML = '';
            totalIncomeField.textContent = '₹0.00';
            totalIncomeOnePer.textContent = '₹0.00';
            modalChildCount.textContent = '...';

            // Fetch downline data
            fetch(`/api/get-downline-income/${userId}`)
                .then(res => res.json())
                .then(data => {
                    let total = 0;

                    if (Array.isArray(data.downlines)) {
                        modalChildCount.textContent = data.downlines.length;
                        data.downlines.forEach(user => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td>${user.name}</td>
                                <td>${user.phone}</td>
                                <td class="text-end ">₹ ${parseFloat(user.amount).toFixed(2)}</td>
                            `;
                            tableBody.appendChild(tr);
                            total += parseFloat(user.amount);
                        });
                    } else {
                        modalChildCount.textContent = '0';
                    }

                    totalIncomeField.textContent = `₹ ${total.toFixed(2)}`;
                    totalIncomeOnePer.textContent = `₹ ${(total * 0.01).toFixed(2)}`;
                })
                .catch(error => {
                    console.error('Error fetching downline data:', error);
                    modalChildCount.textContent = '0';
                });
        });
    });
    });

</script> --}}


{{-- <script>
document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.getElementById('downlineTableBody');
    const totalIncomeField = document.getElementById('totalIncome');
    const totalIncomeOnePer = document.getElementById('totalIncomeOnePer');
    const modalUserName = document.getElementById('modalUserName');
    const modalUserPhone = document.getElementById('modalUserPhone');
    const modalChildCount = document.getElementById('modalChildCount');

    // Flag to prevent multiple requests when double-clicked quickly
    let isLoading = false;

    document.querySelectorAll('.openIncomeModal').forEach(btn => {
        btn.addEventListener('click', function () {
            if (isLoading) return; // prevent rapid multiple calls
            isLoading = true;

            const userName = this.getAttribute('data-user-name');
            const userPhone = this.getAttribute('data-user-phone');
            const userId = this.getAttribute('data-user-id');

            // Reset all fields immediately
            modalUserName.textContent = userName;
            modalUserPhone.textContent = userPhone;
            modalChildCount.textContent = '...';
            tableBody.innerHTML = '';
            totalIncomeField.textContent = '₹0.00';
            totalIncomeOnePer.textContent = '₹0.00';

            // Use a timeout to ensure modal is showing before fetch starts (optional)
            setTimeout(() => {
                fetch(`/api/get-downline-income/${userId}`)
                    .then(res => res.json())
                    .then(data => {
                        let total = 0;
                        if (Array.isArray(data.downlines)) {
                            modalChildCount.textContent = data.downlines.length;
                            data.downlines.forEach(user => {
                                const tr = document.createElement('tr');
                                tr.innerHTML = `
                                    <td>${user.name}</td>
                                    <td>${user.phone}</td>
                                    <td class="text-end">₹ ${parseFloat(user.amount).toFixed(2)}</td>
                                `;
                                tableBody.appendChild(tr);
                                total += parseFloat(user.amount);
                            });
                        } else {
                            modalChildCount.textContent = '0';
                        }

                        totalIncomeField.textContent = `₹ ${total.toFixed(2)}`;
                        totalIncomeOnePer.textContent = `₹ ${(total * 0.01).toFixed(2)}`;
                    })
                    .catch(error => {
                        console.error('Error fetching downline data:', error);
                        modalChildCount.textContent = '0';
                    })
                    .finally(() => {
                        isLoading = false;
                    });
            }, 300); // slight delay ensures modal is visible before data populates
        });
    });
});
</script> --}}

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.getElementById('downlineTableBody');
    const totalIncomeField = document.getElementById('totalIncome');
    const totalIncomeOnePer = document.getElementById('totalIncomeOnePer');
    const modalUserName = document.getElementById('modalUserName');
    const modalUserPhone = document.getElementById('modalUserPhone');
    const modalChildCount = document.getElementById('modalChildCount');
    const modal = document.getElementById('ModalBasic');

    let currentUserId = null;

    document.querySelectorAll('.openIncomeModal').forEach(btn => {
        btn.addEventListener('click', function () {
            const userName = this.getAttribute('data-user-name');
            const userPhone = this.getAttribute('data-user-phone');
            const userId = this.getAttribute('data-user-id');

            // Update modal display values
            modalUserName.textContent = userName;
            modalUserPhone.textContent = userPhone;

            // Reset all fields
            tableBody.innerHTML = '';
            totalIncomeField.textContent = '₹0.00';
            totalIncomeOnePer.textContent = '₹0.00';
            modalChildCount.textContent = '...';
            currentUserId = userId;

            // Defer fetch until modal is fully shown
            const bsModal = bootstrap.Modal.getOrCreateInstance(modal);
            bsModal.show();

            // Wait until modal is actually shown before loading data
            modal.addEventListener('shown.bs.modal', function handler() {
                modal.removeEventListener('shown.bs.modal', handler); // remove after one-time
                fetch(`/api/get-downline-income/${currentUserId}?_=${Date.now()}`) // cache bust
                    .then(res => res.json())
                    .then(data => {
                        let total = 0;

                        if (Array.isArray(data.downlines)) {
                            modalChildCount.textContent = data.downlines.length;
                            data.downlines.forEach(user => {
                                const tr = document.createElement('tr');
                                tr.innerHTML = `
                                    <td>${user.name}</td>
                                    <td>${user.phone}</td>
                                    <td class="text-end">₹ ${parseFloat(user.amount).toFixed(2)}</td>
                                `;
                                tableBody.appendChild(tr);
                                total += parseFloat(user.amount);
                            });
                        } else {
                            modalChildCount.textContent = '0';
                        }

                        totalIncomeField.textContent = `₹ ${total.toFixed(2)}`;
                        totalIncomeOnePer.textContent = `₹ ${(total * 0.01).toFixed(2)}`;
                    })
                    .catch(error => {
                        console.error('Error fetching downline data:', error);
                        modalChildCount.textContent = '0';
                    });
            });
        });
    });

    // Optional: Reset modal when hidden
    modal.addEventListener('hidden.bs.modal', () => {
        currentUserId = null;
        tableBody.innerHTML = '';
    });
});
</script>



<script>

document.getElementById('ModalBasic').addEventListener('hidden.bs.modal', () => {
    document.getElementById('downlineTableBody').innerHTML = '';
});

</script>





@endsection








