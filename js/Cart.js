/******************************************
 * The Cart class
 ******************************************/
onepica.Cart = Class.create({
	initialize: function () {
		this.cartTickerIntervals = [];
		document.observe('lightview:hidden', this.clearCartIntervals.bindAsEventListener(this));
		document.observe('lightview:opened', this.clearCartIntervals.bindAsEventListener(this));

		// product view  page
		this.form = $('product_addtocart_form');
		if (this.form) {
			this.addLink = $('add-to-cart');
			if (this.addLink) {
				this.validator = new Validation(this.form);
				this.addLink.observe('click', this.addToCart.bindAsEventListener(this));
			}
			// else, product may be out of stock
		}
	},
	
	registerCartTicker: function (ticker) {
		this.cartTickerIntervals.push(ticker.interval);
	},

	/**
	 * Clears ticker intervals when the cart is hidden or repopulated.
	 */
	clearCartIntervals: function (evt) {
		for (var i = 0; i < this.cartTickerIntervals.length; i++) {
			clearInterval(this.cartTickerIntervals[i]);
		}
		this.cartTickerIntervals = [];
	},

	registerDeleteLink: function (link) {
		link = $(link);
		link.observe('click', this.deleteLinkClick.bindAsEventListener(this));
		link.setAttribute('url', link.href);
		link.href = 'javascript:;';
	},

	/**
	 * Event fired when one of the cart row X buttons is clicked.
	 */
	deleteLinkClick: function (evt) {
		var link = evt.findElement('a');
		Lightview.show({
			href: link.getAttribute('url'),
			rel: 'ajax'
		});
	},

	/**
	 * Adds an item to the cart via AJAX.
	 */
	addToCart: function (event) {
          
		if (this.validator.validate() && !$('add-to-cart').hasClassName('btn-disabled')) {
			
           
           /* new Ajax.Request(url, {
                method: 'post',
                parameters: this.form.serialize(),
                onSuccess: function(transport) {
                    alert(transport);
                    //arc_top_cart_section_ajax_update();
                    //alert("Item has been added");
                }
              });*/
				
				var url = this.form.action;
                str = this.form.serialize();
				jQuery.ajax({
                    /*async:false,*/
                    type: "POST",
                    dataType:'json',
                    url: url,
                    data: str,
					beforeSend: function()
					{
						jQuery("input#add-to-cart").val("Please wait..");
						jQuery("input#add-to-cart").addClass("btn-disabled");
						
					},
					success: function(data){
                       arc_top_cart_section_ajax_update(data);
					   jQuery("#add-to-cart").val("Add To Bag");
					   jQuery("#add-to-cart").removeClass("btn-disabled");
                       //alert(data);
                    }
                });  
          
            
            
            
            
            return false;
            
            /*Lightview.show({
				href: this.form.action,
				rel: 'ajax',
				options: {
					ajax: {
						method: 'post',
						parameters: this.form.serialize(),
						evalScripts: true
					}					
				}
			});*/
		}
	},

	/**
	 * Shows the cart.
	 */
	show: function () {
		Lightview.show({
			href: $('cart-link').href,
			rel: 'ajax',
			options: {
				ajax: {
					evalScripts: true
				}
			}
		});
	},

	/**
	 * Sets up the cart gift card block
	 */
	initGiftcardForm: function (formId, submitId) {
		this.gcForm = $(formId);
		this.gcFormSubmit = $(submitId);
		if (!this.gcForm || !this.gcFormSubmit) {
			return;
		}
		this.gcValidator = new Validation(this.gcForm);
		this.gcFormSubmit.observe('click', function (evt) {
			if (this.gcValidator.validate()) {
				Lightview.show({
					href: this.gcForm.action,
					rel: 'ajax',
					options: {
						ajax: {
							method: 'post',
							parameters: this.gcForm.serialize(),
							evalScripts: true
						}
					}
				});
			}
		}.bind(this));
	},
	
	/**
	 * Sets up the cart discount code block
	 */
	initDiscountCouponForm: function (formId, submitId, cancelId, cancelVarId) {
		this.dcForm = $(formId);
		this.dcFormSubmit = $(submitId);
		this.dcFormCancel = $(cancelId);
		this.cancelVar = $(cancelVarId);
		if (!this.dcForm || !this.dcFormSubmit) {
			return;
		}
		this.dcValidator = new Validation(this.dcForm);
		this.dcFormSubmit.observe('click', function (evt) {
			if (this.dcValidator.validate()) {
				this.cancelVar.value = "0";
				Lightview.show({
					href: this.dcForm.action,
					rel: 'ajax',
					options: {
						ajax: {
							method: 'post',
							parameters: this.dcForm.serialize(),
							evalScripts: true
						}
					}
				});
			}
		}.bind(this));
		
		if(this.dcFormCancel) {
			this.dcFormCancel.observe('click', function (evt) {
				if (this.dcValidator.validate()) {
					this.cancelVar.value = "1";
					Lightview.show({
						href: this.dcForm.action,
						rel: 'ajax',
						options: {
							ajax: {
								method: 'post',
								parameters: this.dcForm.serialize(),
								evalScripts: true
							}
						}
					});
				}
			}.bind(this));
		}
	}
});