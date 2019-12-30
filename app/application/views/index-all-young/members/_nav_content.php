<?php $menuData = [
    ['href' => base_url('products'), 'icon' => 'icon-shopping-cart', 'text' => 'All products', 'trans' => ''],
    ['href' => base_url('member/wishlist'), 'icon' => 'icon-like', 'text' => 'Wishlist', 'trans' => ''],
    ['href' => "_inni_order.php", 'icon' => 'icon-menu2', 'text' => 'Order Inquiry', 'trans' => ''],
    ['href' => base_url('member/dividend'), 'icon' => 'icon-cash', 'text' => 'Bonus Point Query', 'trans' => ''],
    ['href' => base_url('member/member_dividend_fun'), 'icon' => 'icon-analysis', 'text' => 'Shopping Bouns Inquiry', 'trans' => ''],
    ['href' => base_url('member/info'), 'icon' => 'icon-information', 'text' => 'Information', 'trans' => ''],
    ['href' => "_inni_member_address.php", 'icon' => 'icon-placeholder', 'text' => 'Common Shipping Address', 'trans' => ''],
    ['href' => "_inni_member_announcement.php", 'icon' => 'icon-megaphone', 'text' => 'Member Announcement', 'trans' => ''],
    ['href' => base_url('member/upgrade'), 'icon' => 'icon-id', 'text' => 'Upgrade Management Member', 'trans' => ''],
    ['href' => base_url('member/invite'), 'icon' => 'icon-megaphone', 'text' => 'Invitation Code Sharing', 'trans' => ''],
    ['href' => "_inni_member_sale.php", 'icon' => 'icon-paper', 'text' => 'Management Member Sales Order Inquiry', 'trans' => ''],
    ['href' => "_inni_member_organization.php", 'icon' => 'icon-monitor', 'text' => 'Organization Table', 'trans' => ''],
    ['href' => "_inni_member_invoice.php", 'icon' => 'icon-credit-cards', 'text' => 'I Want to Ask for Money', 'trans' => ''],
    ['href' => "_inni_member_bonus.php", 'icon' => 'icon-money', 'text' => 'Commission Inquiry', 'trans' => ''],
    ['href' => "_inni_member_invoice_list.php", 'icon' => 'icon-credit-cards', 'text' => 'Request Record', 'trans' => ''],
    ['href' => "_inni_faqs.php", 'icon' => 'icon-megaphone-2', 'text' => 'FAQs', 'trans' => ''],
    ['href' => base_url('member/logout'), 'icon' => 'icon-growth', 'text' => 'Logout', 'trans' => ''],
] ?>

<?php foreach ($menuData as $menu) { ?>
    <li>
        <a href="<?= $menu['href'] ?>"><?php if ($hasIcon) { ?><i name="icon02" class="<?= $menu['icon'] ?>"></i><?php } ?><?= $menu['text'] ?></a>
    </li>
<?php } ?>