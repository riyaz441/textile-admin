$(document).ready(function () {
    // datatable js start
    new DataTable('#application-settings-table', {
        layout: {},
        "ordering": false,
        oLanguage: {
            sLengthMenu: "_MENU_",
        }
    });
    // datatable js end

    // modal delete operation start
    $('#deleteModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let Id = button.data('id');
        let Name = button.data('name');
        let form = $('#deleteForm');

        form.attr('action', APP_URL + '/' + Name + '/' + Id);
    });
    // modal delete operation end

    // load branches by company for application settings form
    const $companySelect = $('#company_id');
    const $branchSelect = $('#branch_id');
    if ($companySelect.length && $branchSelect.length) {
        const resetBranchSelect = () => {
            $branchSelect.html('<option value="">Select Branch</option>');
            $branchSelect.prop('disabled', !$companySelect.val());
        };

        const populateBranches = (companyId, selectedId) => {
            $branchSelect.prop('disabled', true);
            $branchSelect.html('<option value="">Loading...</option>');
            $.ajax({
                url: APP_URL + '/get_branch_by_company',
                type: 'GET',
                data: { company_id: companyId },
                success: function (response) {
                    if (!response.success) {
                        resetBranchSelect();
                        return;
                    }

                    let options = '<option value="">Select Branch</option>';
                    $.each(response.branches || [], function (index, branch) {
                        const isSelected = String(branch.branch_id) === String(selectedId) ? ' selected' : '';
                        options += `<option value="${branch.branch_id}"${isSelected}>${branch.branch_name}</option>`;
                    });

                    $branchSelect.html(options);
                    $branchSelect.prop('disabled', false);
                },
                error: function () {
                    resetBranchSelect();
                }
            });
        };

        $companySelect.on('change', function () {
            const companyId = $(this).val();
            if (!companyId) {
                resetBranchSelect();
                return;
            }
            populateBranches(companyId, $branchSelect.data('selected'));
        });

        const initialCompanyId = $companySelect.val();
        if (initialCompanyId) {
            populateBranches(initialCompanyId, $branchSelect.data('selected'));
        } else {
            resetBranchSelect();
        }
    }
});
