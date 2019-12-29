<div id="tt-pageContent" class="main-content ">
    <div class="container-indent">
        <div class="container">

            <main class="main-content">
                <div class="container openside pall0">

                    <?php $this->load->view($indexViewPath . '/members/_sidenav'); ?>
                    
                    <section class="content has-side">
                        <div class="title">Order Inquiry</div>
                        <div class="order-detail">
                            <table class="table table-v en">
                                <tbody>
                                    <tr>
                                        <th>Order Number</th>
                                        <td><strong>20190912140926103</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="clearfix">
                                <table class="table table-v en">
                                    <tbody>
                                        <tr>
                                            <th>Order Date</th>
                                            <td>2019-09-12 14:09:26</td>
                                        </tr>
                                        <tr>
                                            <th>Recipient's Name</th>
                                            <td>Joy</td>
                                        </tr>
                                        <tr>
                                            <th>Recipient's Phone</th>
                                            <td>229956488</td>
                                        </tr>
                                        <tr>
                                            <th>Receiver's Address</th>
                                            <td>8th Floor, No.4, Lane 609, Section 5, Zhongwei Road,<br> Wanli District, New Taipei City, Taiwan</td>
                                        </tr>
                                        <tr>
                                            <th>Total of orders</th>
                                            <td><strong>$53</strong></td>
                                        </tr>
                                        <tr>
                                            <th>Payment Method</th>
                                            <td>Online Card</td>
                                        </tr>
                                        <tr>
                                            <th>Payment Status</th>
                                            <td>Paid </td>
                                        </tr>
                                        <tr>
                                            <th>Delivery Method</th>
                                            <td>Mailing Registration</td>
                                        </tr>
                                        <tr>
                                            <th>Delivery Status</th>
                                            <td>Arrived /<span class="transport">黑貓</span></td>
                                        </tr>
                                        <tr>
                                            <th>Remarks</th>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="title invoiceBox">Invoice Information
                            <a href="javascript:void(null)">
                                <div name="contactForm" value="openForm">
                                    <i class="icon-f-82" aria-hidden="true"></i>
                                </div>
                            </a>
                        </div>
                        <div class="order-detail insidebox">
                            <table class="table table-v en">
                                <tbody>
                                    <tr>
                                        <th>Invoice status</th>
                                        <td>Opened</td>
                                    </tr>
                                    <tr>
                                        <th>Invoice Request Type</th>
                                        <td>Cloud invoice</td>
                                    </tr>
                                    <tr>
                                        <th>invoice type</th>
                                        <td>Two-way Invoice</td>
                                    </tr>
                                    <tr>
                                        <th>Vehicle Type</th>
                                        <td>XCMVV13646(Member Vehicle)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="title mt-4">Shopping List</div>
                        <table class="table table-h cart-table">
                            <thead>
                                <tr>
                                    <th class="align-left" colspan="2">Product Name</th>
                                    <th>Amount</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="img">
                                        <a href="/products/detail/228" class="pic"><img src="images/cart/pro01.jpg" alt="Product Name"></a>
                                    </td>
                                    <td class="info align-left">
                                        <a href="/products/detail/228">
                                            <span class="pd-name">Product Name</span>
                                        </a>
                                    </td>
                                    <td data-title="Amount：">USD$20.00</td>
                                    <td data-title="Quantity：">2</td>
                                    <td data-title="Subtotal：">$40.00</td>
                                </tr>
                                <tr>
                                    <td class="img">
                                        <a href="/products/detail/166" class="pic"><img src="images/cart/pro02.jpg" alt="Product Name"></a>
                                    </td>
                                    <td class="info align-left">
                                        <a href="/products/detail/166">
                                            <span class="pd-name">Product Name</span>
                                        </a>
                                    </td>
                                    <td data-title="Amount：">$13.00</td>
                                    <td data-title="Quantity：">1</td>
                                    <td data-title="Subtotal：">USD$13.00</td>
                                </tr>

                            </tbody>
                        </table>
                        <div class="sum-box">
                            <form id="order_detail_form" method="POST">
                                <table class="table table-h sum-table">
                                    <tfoot>
                                        <tr>
                                            <td>Subtotal</td>
                                            <td>$53</td>
                                        </tr>
                                        <tr>
                                            <td>Freight</td>
                                            <td>$0</td>
                                        </tr>
                                        <tr>
                                            <td>Total</td>
                                            <td>$53</td>
                                        </tr>
                                        <tr>
                                            <td>Use Bonus</td>
                                            <td>0.00</td>
                                        </tr>
                                        <tr>
                                            <td>Use Shopping Gold</td>
                                            <td>0.00</td>
                                        </tr>
                                        <tr>
                                            <td>Need to Use Cash</td>
                                            <td>$53.00</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                This Purchase Can be Re-Acquired: Bonus of <span class="color01">0.00 Points</span>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </form>
                        </div>

                        <div class="title mt-4 underbor-x">Order Inquiry</div>
                        <div class="col-12">
                            <div class="editor mg mt-0">
                                <div class="form-group">
                                    <div class="control-box">
                                        <textarea id="tooltip02" class="form-control" style="height:210px" name="order_content" cols="" rows="" title="What Do You Want to Say?" placeholder="What Do You Want to Say?"></textarea>
                                    </div>
                                </div>

                                <div class="uploadpic">
                                    <label class="btn btn-upload">
                                        <input id="upload_img" type="file">
                                        <i class="fa fa-cloud-upload"></i>Upload Image
                                    </label>

                                    <div class="btnbox uploadbtn">
                                        <input type="hidden" name="dbname" value="contact">
                                        <input type="submit" class="btn simple bg2 btn-green-bg" value="Send">
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="pagination_box">
                            <input type="hidden" name="order_id" id="order_id" value="103">
                            <a href="order.php" class="btn back btn-green-bg"><i name="icon02" class="icon-chevron-left" aria-hidden="true"></i> Back</a>
                        </div>
                    </section>


                </div>
            </main>


        </div>
    </div>
</div>