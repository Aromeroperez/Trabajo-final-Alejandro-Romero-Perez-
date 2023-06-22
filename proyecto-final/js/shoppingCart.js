export let shoppingCart = () => {
  const payAmountBtn = document.querySelector('#payAmount');
  const decrementBtn = document.querySelectorAll('#decrement');
  const quantityElem = document.querySelectorAll('#quantity');
  const incrementBtn = document.querySelectorAll('#increment');
  const priceElem = document.querySelectorAll('#price');
  const subtotalElem = document.querySelector('#subtotal');
  const taxElem = document.querySelector('#tax');
  const totalElem = document.querySelector('#total');

  // Objeto para realizar el seguimiento de la cantidad de productos
  const productQuantity = {};

  // Inicializar el seguimiento de la cantidad de productos
  for (let i = 0; i < quantityElem.length; i++) {
    const productID = quantityElem[i].dataset.productID;
    const productQuantityValue = Number(quantityElem[i].textContent);
    productQuantity[productID] = productQuantityValue;
  }

  const totalCalc = function () {
    const tax = 0.21;
    let subtotal = 0;
    let totalTax = 0;
    let total = 0;

    for (let i = 0; i < quantityElem.length; i++) {
      const productID = quantityElem[i].dataset.productID;
      const productQuantityValue = productQuantity[productID];
      subtotal += productQuantityValue * Number(priceElem[i].textContent);
    }

    subtotalElem.textContent = subtotal.toFixed(2);
    totalTax = subtotal * tax;
    taxElem.textContent = totalTax.toFixed(2);
    total = subtotal + totalTax;
    totalElem.textContent = total.toFixed(2);
    payAmountBtn.textContent = total.toFixed(2);
  };

  // Calcular los totales al cargar la página
  totalCalc();

  for (let i = 0; i < incrementBtn.length; i++) {
    incrementBtn[i].addEventListener('click', function () {
      const productID = this.dataset.productID;
      productQuantity[productID] += 1;
      quantityElem[i].textContent = productQuantity[productID];
      totalCalc();
    });

    decrementBtn[i].addEventListener('click', function () {
      const productID = this.dataset.productID;
      productQuantity[productID] = Math.max(productQuantity[productID] - 1, 1);
      quantityElem[i].textContent = productQuantity[productID];
      totalCalc();
    });
  }
};

