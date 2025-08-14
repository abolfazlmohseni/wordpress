<?php
get_header();
$price = get_post_meta(get_the_ID(), 'old_price', true);
$orgprice = get_post_meta(get_the_ID(), 'finalPrice', true);
$SensorType = get_post_meta(get_the_ID(), "SensorType", true);
$SensorDisconnection = get_post_meta(get_the_ID(), "SensorDisconnection", true);
?>
<div class="max-w-screen-lg mx-auto mt-10">
    <div class="overflow-hidden rounded-xl">
        <?= the_post_thumbnail('full') ?>
    </div>
    <div class="flex w-full justify-between mt-4">
        <p class="font-bold text-2xl text-zinc-800"><?= the_title() ?></p>
        <div class="flex items-center justify-between w-1/3">
            <?php
            if ($price) {
            ?>
                <div class="rounded-md p-1 bg-red-600 text-white w-fit">
                    <p><?= round((($price - $orgprice) / $price) * 100) ?>%</p>
                </div>

            <?php
            }
            if ($price) {

            ?>
                <p class="text-gray-500 line-through"><?= number_format($price)  ?></p>
            <?php
            }

            ?>
            <p class="text-zinc-800 text-2xl font-bold"><?= number_format($orgprice) ?></p>
            <p class="text-gray-500 text-sm">تومان</p>
        </div>
    </div>
    <div class="mt-6 text-gray-500 w-full text-base/8">
        <?= the_content() ?>
    </div>
    <button class="py-2 px-2.5 rounded-lg bg-blue-500 text-white mt-6 flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"></path>
        </svg>
        <span>افزودن به سبد</span>
    </button>
    <div class="mt-6 space-y-3">
        <p class="text-2xl font-bold text-zinc-800">ویژگی ها</p>
        <?php if ($SensorType) {
        ?>
            <li class="text-gray-500 text-sm"><span class="ml-3">نوع حسگر:</span><span class="text-zinc-800 font-bold "><?= $SensorType ?></span></li>
        <?php
        }
        if ($SensorType) {
        ?>
            <li class="text-gray-500 text-sm"><span class="ml-3">قطع حسگر:</span><span class="text-zinc-800 font-bold "><?= $SensorDisconnection ?></span></li>

        <?php
        } ?>
    </div>
</div>



<?=
get_footer();
?>