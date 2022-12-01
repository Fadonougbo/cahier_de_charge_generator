class menuBurger
{
	constructor()
	{
		this.spanContainner=document.querySelector(".menuIconContainner")
		this.aside=document.querySelector("header aside")

		this.toggleAside()
		
	}

	toggleAside(a)
	{
		let onClick=(e)=>
		{
			this.aside.classList.toggle("visible")
			this.spanContainner.classList.toggle("rotate")
			document.body.classList.toggle("hidden")
	
			
		}


		this.spanContainner.addEventListener("click",onClick)
	}
}

new menuBurger()