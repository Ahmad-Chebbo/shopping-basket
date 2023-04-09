"use strict";

let removedItemsTable = $('#removed_items_table');
let removedItemsDatatable;

// removedItem datatable
let initremovedItemDatatable = () =>
{
    let url  = route('removed.index');
    let columns = [
        {
            data: 'product_id',
            ordering: true,
            className: "text-start",
        },
        {
            data: 'product.image',
            className: 'text-start',
            render: function (data, type, row, meta) {
                if (data == null) {
                    return `<img src='/manage/images/empty.jpg' class="img-thumbnail rounded-circle w-100" alt="Empty Image">`;
                }
                return `<img src="${data}" class="img-thumbnail rounded-circle w-100" alt="${row.name}">`;
            }
        },
        {
            data: 'product.name',
            ordering: true,
        },
        {
            data: 'product.price',
            ordering: true,
        },
        {
            data: 'total_removed',
            ordering: true,
            render: function (data, type, row, meta) {

                return `<span class="badge badge-primary fs-6">${data}</span>`;
            }
        },
        {
            name: '',
            data: null ,
            className: 'text-end',
            render: function (data, type, row){
                let html = '';
                html += `
                <a href="#" title="Delete" data-id="` + row.product_id + `" class="delete-btn btn btn-icon btn-bg-light btn-active-color-danger btn-sm">
                    <i class="fas fa-trash"></i>
                </a>
                `;
                return html;

            }
        },
    ];
    removedItemsDatatable = initDataTable("GET", removedItemsTable, removedItemsDatatable, url, null, columns, null, null);
    if (removedItemsDatatable) {
        removedItemsDatatable.on('draw', function () {
            initRemoveremovedItem();
        });
    }
}


// Remove removedItem
let initRemoveremovedItem = () => {
    let deleteBtn = removedItemsTable.find('.delete-btn');
    deleteBtn.on('click', function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        let url = route('removed.destroy', id);
        initShowConfirmationAlert("", url, 'DELETE', null, removedItemsDatatable, null, false, true, true, true);
    });
}

$(document).ready(function () {
    // Init removedItems datatable
    initremovedItemDatatable();
    // handle search
    handleSearchDatatable(removedItemsDatatable);
});
