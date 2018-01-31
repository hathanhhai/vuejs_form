<div class="row">

    <div class="col-sm-4">

        <div class="form-group">

            <label>Invoice No.</label>
            <input type="text" class="form-control  " v-model="form.invoice_no"/>
            <p style="color:red" v-if="errors.invoice_no" class="error">@{{ errors.invoice_no[0] }}</p>

        </div>

        <div class="form-group">

            <label>Client</label>
            <input type="text" class="form-control " v-model="form.client"/>
            <p style="color:red" v-if="errors.client" class="error">@{{ errors.client[0] }}</p>

        </div>

    </div>

    <div class="col-sm-4">

        <div class="form-group">

            <label>Client Adress</label>
            <textarea type="text" rows="5" class="form-control " v-model="form.client_address"></textarea>
            <p style="color:red" v-if="errors.client_address" class="text-error">@{{ errors.client_address[0] }}</p>

        </div>

    </div>


    <div class="col-sm-4">

        <div class="form-group">

            <label>Title</label>
            <input type="text" class="form-control " v-model="form.title"/>
            <p  style="color:red" v-if="errors.title" class="error">@{{ errors.title[0] }}</p>

        </div>
        <div class="row">

            <div class="form-group col-sm-6">

                <label>Invoice Date</label>
                <input type="date" class="form-control " v-model="form.invoice_date"/>
                <p style="color:red" v-if="errors.invoice_date" class="error">@{{ errors.invoice_date[0] }}</p>

            </div>

            <div class="form-group col-sm-6">

                <label>Due Date</label>
                <input type="date" class="form-control " v-model="form.due_date"/>
                <p style="color:red" v-if="errors.due_date" class="error">@{{ errors.due_date[0] }}</p>

            </div>

        </div>





    </div>


</div>
<hr/>
<div v-if="empty.products_empty">
    <p class="alert alert-danger">@{{ errors.products_empty }}</p>
    <hr/>
</div>

<table class="table table-bordered table-form">

    <thead>

    <tr>

        <th>Product Name</th>
        <th>Price</th>
        <th>Qty</th>
        <th>Total</th>

    </tr>

    </thead>

    <tbody>

    <tr v-for="product,key in form.products">

        <td class="table-name"   :class="{'alert alert-danger':errors['products.'+key+'.name']}">

            <textarea class="table-control" v-model="product.name"></textarea>

        </td>

        <td class="table-price" :class="{'alert alert-danger':errors['products.'+key+'.price']}">

            <input type="text" class="table-control" v-model="product.price" />

        </td>

        <td class="table-qty" :class="{'alert alert-danger':errors['products.'+key+'.qty']}">

            <input type="text" class="table-control"  v-model="product.qty"/>

        </td>

        <td class="table-total">

            <span class="table-text">@{{ product.qty*product.price }}</span>

        </td>

        <td class="table-remove">

            <a @click="remove(product)" style="text-align: center;font-size:25px;color:red;" class="table-remove-btn">&times;</a>

        </td>

    </tr>

    </tbody>
    <tfoot>

    <tr >
        <td class="table-empty" colspan="2">
            <a @click="addLine" class="table-add_line">Add Line</a>
        </td>
        <td class="table-label">Sub Total</td>
        <td class="table-amount">@{{ subTotal }}</td>

    </tr>

    <tr>
        <td class="table-empty" colspan="2"></td>
        <td class="table-label">Discount</td>
        <td class="table-discount" :class="{'table-error':errors.discount}">

            <input type="text" class="table-discount_input" v-model="form.discount" />

        </td>

    </tr>

    <tr>
        <td class="table-empty"  colspan="2"></td>
        <td class="table-label">Grand Total</td>
        <td class="table-amount">@{{ grandTotal }}</td>

    </tr>

    </tfoot>

</table>
