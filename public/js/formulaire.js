
class FormulaireSlider
{
	constructor()
	{

		
		this.containner=document.querySelector("form .containner")
		this.form=document.querySelector("form")
		this.navigationContainnerParent=document.querySelector("#navigationContainner").parentElement
		this.items=[...this.containner.querySelectorAll(".div_responsive")]
		this.btn=document.querySelectorAll("#navigationContainner .nav")
		this.submitBtn=document.querySelector("#navigationContainner #option")
		this.i=0

        this.options={nbElementVisible:1,nbSlide:1}
		this.setStyle()
		this.createProgressBar()
		this.slide()

		
		

	}

	setStyle()
	{	
		/*containner style*/
		let ratio=this.containner.children.length/this.options.nbElementVisible
		this.containner.style.width=`${ratio*100}%`
        this.itemWidth=(1/ratio)*100
		/*items style*/

		this.items.forEach((el)=>
		{
			el.style.width=`${this.itemWidth}%`

		})

	}

	previousBtnStatus()
	{
		if(this.i===0)
		{
			this.btn[0].style.display="none"
		}else 
		{
			this.btn[0].style.display="block"
		}


		if(this.i===(this.containner.children.length/this.options.nbElementVisible)-this.options.nbSlide)
		{
			this.btn[1].style.display="none"
		}else 
		{
			this.btn[1].style.display="block"
		}

		if(this.i<(this.containner.children.length/this.options.nbElementVisible)-this.options.nbSlide)
		{
			this.submitBtn.style.display="none"

		}else 
		{
			this.submitBtn.style.display="block"
		}
		
	}

	slide()
	{	

		this.previousBtnStatus()

		let currentValue=(this.i+1)*100
        let max=this.containner.children.length*100

		this.progressBarChange(currentValue,max)

		let onClick=(e)=>
		{	
			e.preventDefault()
			

			if (e.currentTarget.id==="next") 
			{ 
				if(this.i<(this.containner.children.length/this.options.nbElementVisible)-this.options.nbSlide)
			    {    this.i+=1
					
			    }


			}else 
			{
				if (this.i>0)
				 {
                    this.i-=1
				 	
				 }	
			}
            this.previousBtnStatus()
            currentValue=(this.i+1)*100
            this.progressBarChange(currentValue,max)
			this.containner.style.transform=`translateX(-${this.itemWidth*this.i}%)`
			
		}


		this.btn.forEach((el)=>
		{
			el.addEventListener("click",onClick)
		})
	}
	createProgressBar()
	{	
		this.div=document.createElement("div")
		this.progress=document.createElement("progress")
		this.div.appendChild(this.progress) 
		this.form.insertBefore(this.div,this.navigationContainnerParent)
	}

	progressBarChange(value,max)
	{
		this.progress.value=value
		this.progress.max=max
	}

	



	

}

new FormulaireSlider();


