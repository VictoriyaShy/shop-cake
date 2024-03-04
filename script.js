// Проверяем, было ли предупреждение о куки уже показано
if (!localStorage.getItem('cookieAlertShown')) {
    document.getElementById('cookie-alert').style.display = 'block';
}

function acceptCookies() {
    localStorage.setItem('cookieAlertShown', true);
    document.getElementById('cookie-alert').style.display = 'none';
}


function validateForm() {
    // Проверяем состояние скрытой кнопки
    var hiddenSubmitButton = document.getElementById('hidden-submit');
    if (hiddenSubmitButton.clicked) {
        alert("Форма не может быть отправлена. Пожалуйста, повторите попытку.");
        return false; // Останавливаем отправку формы
    }
    return true; // Продолжаем отправку формы
}

document.getElementById('hidden-submit').addEventListener('click', function() {
    this.clicked = true; // Устанавливаем флаг clicked в true при нажатии на скрытую кнопку
});


let cart = JSON.parse(localStorage.getItem('cart')) || [];

function addToCart(product, price) {
    const quantity = document.getElementById(`${product}-quantity`).value;
    if (parseInt(quantity) === 0) {
        alert("Количество товара должно быть больше нуля.");
        return; // Остановка добавления товара в корзину
    }
    const existingItemIndex = cart.findIndex(item => item.product === product);
    if (existingItemIndex !== -1) {
        cart[existingItemIndex].quantity += parseInt(quantity);
    } else {
        cart.push({ product: product, price: price, quantity: parseInt(quantity) });
    }
    updateCart();
    // Сохраняем корзину в localStorage
    localStorage.setItem('cart', JSON.stringify(cart));
}



function updateCart() {
    let cartItems = document.getElementById("cart-items");
    let totalPrice = 0;
    let totalItems = 0;
    cartItems.innerHTML = "";
    cart.forEach(item => {
        if (item.quantity > 0) {
            let newItem = document.createElement("li");

            // Создаем элементы для отображения наименования товара и его цены
            let productNameElement = document.createElement("span");
            productNameElement.textContent = `${item.product}`;

            let priceElement = document.createElement("span");
            priceElement.textContent = `:  ${item.price} ₽ `;

            // Добавляем кнопки для изменения количества товара
            let increaseButton = document.createElement("button");
            increaseButton.textContent = "+";
            increaseButton.className = "btn-cart";
            increaseButton.addEventListener("click", function() {
                changeQuantity(item.product, 1);
            });

            let decreaseButton = document.createElement("button");
            decreaseButton.textContent = "-";
            decreaseButton.className = "btn-cart";
            decreaseButton.addEventListener("click", function() {
                changeQuantity(item.product, -1);
            });

            // Создаем элемент для отображения выбранного количества товара
            let quantityElement = document.createElement("span");
            quantityElement.textContent = ` x ${item.quantity}`;

            // Создаем элемент для отображения общей суммы по товару
            let totalItemPriceElement = document.createElement("span");
            totalItemPriceElement.textContent = ` =  ${item.price * item.quantity} ₽`;

            newItem.appendChild(productNameElement);
            newItem.appendChild(priceElement);
            newItem.appendChild(quantityElement);
            newItem.appendChild(increaseButton);
            newItem.appendChild(decreaseButton);
            
            newItem.appendChild(totalItemPriceElement);

            cartItems.appendChild(newItem);
            totalPrice += item.price * item.quantity;
            totalItems += item.quantity;
        } else {
            // Удаляем товар из корзины, если его количество стало равным 0
            const index = cart.findIndex(cartItem => cartItem.product === item.product);
            if (index !== -1) {
                cart.splice(index, 1);
            }
        }
    });

    document.getElementById("total-price").textContent = `Общая сумма (руб.): ${totalPrice}`;
    document.getElementById("cart-content").value = JSON.stringify(cart);

    // Обновляем счетчик корзины
    document.getElementById("cart-counter").textContent = ` ${totalItems} товаров, ₽${totalPrice}`;
}




function changeQuantity(product, amount) {
    const index = cart.findIndex(item => item.product === product);
    if (index !== -1) {
        // Изменяем количество товара
        cart[index].quantity += amount;
        if (cart[index].quantity < 0) {
            cart[index].quantity = 0; // Гарантируем, что количество не станет отрицательным
        }
        updateCart(); // Обновляем отображение корзины
        // Сохраняем измененную корзину в localStorage
        localStorage.setItem('cart', JSON.stringify(cart));
    }
}

    
function clearCart() {
    cart = []; // Очищаем корзину
    updateCart(); // Обновляем отображение корзины
    // Сохраняем пустую корзину в localStorage
    localStorage.setItem('cart', JSON.stringify(cart));
}

// Загружаем корзину при загрузке страницы
window.onload = function() {
    updateCart();
};


