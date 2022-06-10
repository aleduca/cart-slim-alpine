<?php $this->layout('master', ['title' => $title]) ?>

<h2>Products</h2>

<div x-data="cart" x-init="getProducts">

    <ul>
        <?php foreach ($products as $product): ?>
            <li>
                <?php echo $product->name ?> R$<?php echo number_format($product->price, 2, ',', '.') ?>
                <button @click="add(<?php echo $product->id; ?>)">Add</button>

                <template x-if="inCart(<?php echo $product->id ?>)">
                    <span>
                        <span x-html="subtotal(<?php echo $product->id; ?>,<?php echo $product->price; ?>)"></span>
                        <button @click="remove(<?php echo $product->id; ?>)">Remove</button>
                    </span>
                </template>
            </li>    
            <?php endforeach; ?>
    </ul>

    <button @click="clear">Clear</button>
</div>