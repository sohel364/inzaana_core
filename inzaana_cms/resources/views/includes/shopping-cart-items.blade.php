<li>
    <span class="item">
      <span class="item-left">
          <img src="{{ json_decode($cart_item)->image_url }}" alt="" />
          <span class="item-info">
              <span>{{ json_decode($cart_item)->title }}</span>
              <span>{{ json_decode($cart_item)->mrp }}</span>
          </span>
      </span>
      <span class="item-right">
          <button class="btn btn-xs btn-danger pull-right">x</button>
      </span>
  </span>
</li>