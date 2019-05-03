"use strict";
var KTDatatablesAdvancedColumnRendering = function() {

    var initTable1 = function() {
        var table = $('#kt_table_1');

        // begin first table
        return table.DataTable({
            responsive: true,
            paging: true,
            order: [
                [0, 'desc']
            ],
            columnDefs: [{
                    targets: 0,
                    title: 'Artist',
                    render: function(data, type, full, meta) {

                        var stateNo = KTUtil.getRandomInt(0, 7);
                        var states = [
                            'success',
                            'brand',
                            'danger',
                            'accent',
                            'warning',
                            'metal',
                            'primary',
                            'info'
                        ];
                        var state = states[stateNo];
                        var output = `
                                <div class="kt-user-card-v2">
                                    <div class="kt-user-card-v2__pic">
                                        <div class="kt-badge kt-badge--xl kt-badge--` + state + `"><span>` + full[2].substring(0, 1) + `</div>
                                    </div>
                                    <div class="kt-user-card-v2__details">
                                        <span class="kt-user-card-v2__name">` + full[2] + `</span>
                                        <a href="#" class="kt-user-card-v2__email kt-link">` + full[3] + `</a>
                                    </div>
                                </div>`;

                        return output;
                    },
                },
                {
                    targets: 1,
                    render: function(data, type, full, meta) {
                        return '<a class="kt-link" target="_blank" href="' + data + '">' + data + '</a>';
                    },
                },
                {
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return `
                        <span class="dropdown">
                            <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
                              <i class="la la-ellipsis-h"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item btn-approve" id="btn-approve" href="#" data-id="` + full[0] + `"><i class="la la-edit"></i> Approve</a>
                                <a class="dropdown-item btn-review" id="btn-review" href="#" data-id="` + full[0] + `"><i class="la la-leaf"></i> Review</a>
                                <a class="dropdown-item btn-trash" id="btn-trash" href="#" data-id="` + full[0] + `"><i class="la la-print"></i> Trash</a>
                            </div>
                        </span>
                        <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
                          <i class="la la-edit"></i>
                        </a>`;
                    },
                },
                {
                    targets: 6,
                    render: function(data, type, full, meta) {
                        var status = {
                            1: { 'title': 'Approved', 'class': ' kt-badge--success' },
                            2: { 'title': 'Trashed', 'class': ' kt-badge--danger' },
                            3: { 'title': 'New', 'class': 'kt-badge--metal' },
                            4: { 'title': 'Review', 'class': 'kt-badge--brand' },
                        };
                        if (typeof status[data] === 'undefined') {
                            return data;
                        }
                        return '<span class="kt-badge ' + status[data].class + ' kt-badge--inline kt-badge--pill">' + status[data].title + '</span>';
                    },
                },
                {
                    targets: 7,
                    render: function(data, type, full, meta) {
                        var status = {
                            1: { 'title': 'Progs', 'state': 'danger' },
                            2: { 'title': 'Waitn', 'state': 'primary' },
                            3: { 'title': 'Done', 'state': 'accent' },
                        };
                        if (typeof status[data] === 'undefined') {
                            return data;
                        }
                        return '<span class="kt-badge kt-badge--' + status[data].state + ' kt-badge--dot"></span>&nbsp;' +
                            '<span class="kt-font-bold kt-font-' + status[data].state + '">' + status[data].title + '</span>';
                    },
                },
                // { "visible": false, "targets": 3 },
            ],

        });

    };

    return {

        //main function to initiate the module
        init: function() {
            return initTable1();
        }
    };
}();

jQuery(document).ready(function() {
    var dataTables = KTDatatablesAdvancedColumnRendering.init();
    var filterAllStatus = jQuery("#filter-all-status");
    filterAllStatus.on('click', function() {
        dataTables.columns(6).search("").draw();
    });
    var filterPendingStatus = jQuery("#filter-pending-status");
    filterPendingStatus.on('click', function() {
        dataTables.columns(6).search("New").draw();
        // dataTable.columns(6).search("Rejected|Done", true, false, true).draw();
    });
    var filterApprovedStatus = jQuery("#filter-approved-status");
    filterApprovedStatus.on('click', function() {
        dataTables.columns(6).search("Approved").draw();
    });
    var filterTrashedStatus = jQuery("#filter-trashed-status");
    filterTrashedStatus.on('click', function() {
        dataTables.columns(6).search("Trashed").draw();
    });

    var filterAllProcess = jQuery("#filter-all-process");
    filterAllProcess.on('click', function() {
        dataTables.columns(7).search("").draw();
    });
    var filterDoneProcess = jQuery("#filter-done-process");
    filterDoneProcess.on('click', function() {
        dataTables.columns(7).search("Done").draw();
    });
    var filterProgessProcess = jQuery("#filter-progress-process");
    filterProgessProcess.on('click', function() {
        dataTables.columns(7).search("In Progress").draw();
        // dataTable.columns(4).search("Rejected|Done", true, false, true).draw();
    });

    var filterWaitingProcess = jQuery("#filter-waiting-process");
    filterWaitingProcess.on('click', function() {
        dataTables.columns(7).search("Waiting List").draw();
    });


})