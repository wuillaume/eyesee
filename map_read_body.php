
<?php
    if (isset($_GET['form_id'])) {
      //  echo $_GET['form_id'];
        $form_id = $_GET['form_id'];
    }else{
        // Fallback behaviour goes here
        echo "THERE IS NO FORM ENTERED";
    }
?>

<?php
$result = $bdd->query("SELECT * FROM form_id WHERE form_id = $form_id");
$dataForm = $result->fetch();
$formName = $dataForm['form_name'];

$result = $bdd->query("SELECT * FROM step INNER JOIN form ON form.step_id = step.step_id WHERE form_id = $form_id");
?>

<h1>
 <?php echo htmlspecialchars($formName); ?>
</h1>
<div id="c">



<?php


/* We get each step one by one */
while ($data = $result->fetch())
{
  $classFontsize = "btn-font-".htmlspecialchars($dataForm['btn_font_size']);
?>
<button type="button" class="btn btn-warning btn-arrow-right <?php echo htmlspecialchars($classFontsize) ?>" onclick="show(<?php echo htmlspecialchars($data['step_id']); ?>)"><?php echo htmlspecialchars($data['title']); ?></button>
  
<?php
}
?>

<!--
<button type="button" class="btn btn-warning btn-arrow-right" onclick="show(1)">1 - OPEN</button>
<button type="button" class="btn btn-warning btn-arrow-right" onclick="show(2)">2 - RESISTANCE HANDLING</button>

<button type="button" class="btn btn-warning btn-arrow-right" onclick="show(3)">3 - GENERAL INTEREST</button>

<button type="button" class="btn btn-warning btn-arrow-right" onclick="show(4)">4 - WHAT THEY KNOW</button>

<button type="button" class="btn btn-warning btn-arrow-right" onclick="show(5)">5 - PROBLEM, IMPLICATION, <br>NEED, PAYOFF</button>

<button type="button" class="btn btn-warning btn-arrow-right" onclick="show(6)">6 - WHAT THEY LIKE</button>

<button type="button" class="btn btn-warning btn-arrow-right" onclick="show(7)">7 - GENUINE INTEREST</button>

<button type="button" class="btn btn-warning btn-arrow-right" onclick="show(8)">8 - NEWSLETTER</button>

<button type="button" class="btn btn-warning btn-arrow-right" onclick="show(9)">9 - SCHEDULING, ADMINISTRATION, <br>FACT FIND, GENERAL COMMENTS,<br>AREAS OF INTEREST</button>

-->
</div>



<?php
$result2 = $bdd->query('SELECT * FROM step');
?>
<div id="contentText">

<?php
/* We get each step one by one */
while ($data2 = $result2->fetch())
{
?>
<div id="content<?php echo htmlspecialchars($data2['step_id']); ?>" class="content hidden">

<p>
 <?php echo htmlspecialchars_decode($data2['text']); ?>
</p>
 <p>

<?php

if (!empty($data2['recording'])){
	?>
Play a recording : 

<audio controls="" disabled="disabled" name="view_field15_Client" id="view_field15_Client">  <source src="Recordmp3js-master/recordings/<?php echo htmlspecialchars($data2['recording']) ?>" type="audio/wav">


<?php
}


 ?>
</p>
 <p>
</p>
</div>


  
<?php


}
?>


<!--
<div id="content1" class="content hidden">


 <p>
 “Not sure if you remember, but from time to time, we publish market reports and introduce new ideas to IFA's and investors. The last time we spoke it was about EIS  / XYZ or  To jog your memory - we identify business´ in high growth sectors - companies pay us to carry out primary due diligence on their products so that they can be introduced to our investor network.”


“We currently have over 80,000 investors in our network who are all HNW or Sophisticated Investors; and our service to them is free. Can I assume, Mr Jones, that  - like most switched on guys - you’re willing to look at sensible, well presented ideas?”

</p>
 

</div>
<div id="content2" class="content hidden">
 <p>
“ I´m sure you agree that the quality of the decisions people make., depends entirely on the strength of the information available to them and their ability to process that data.

As a company, we have two activities:
First of all  - we aim to introduce best of class providers of investments - who can deliver high returns to their clients, we carry out primary due diligence on the companies we feature, which provides comfort to our investors, many of whom buy into the ideas we feature

The second thing we do is to try and identify private equity opportunities that would be otherwise inaccessible. We are the first SPP (Secondary private placement) investor relation’s platform in the UK.
igestible, no nonsense market reports and investment guides that provide balanced overviews of ideas that many investors are unfamiliar with, that could potentially improve portfolio performance and portfolio diversification, Now that you know a bit more about who we are... 
I´d like to give you a bit of information about a recent idea, would that be OK? .”
 </p>

  

</div>
<div id="content3" class="content hidden">



 <p>
Would an investment with a 16% per year return, that was asset backed be of interest?
One of the more interesting ideas around now - relates to exceptional growth in the fine wine sector - you may have read recent articles in the telegraph and the FT. 
 </p>

 

</div>
<div id="content4" class="content hidden">



Do you know much about the sector, such as what drives the market and why it's considered so secure? ----------  ( wait ) 
In a nutshell, FINE WINE will always continue to go up in value as long as it is being consumed.  
In France there is a law that limits the amount of Vintage wine a Chateau can produce, giving it intrinsic value. The top 50 wines in the world increase, by at least 1% per month. 
Obviously a vintage from 2006 is worth more than an identical vintage from 2016.
So as an investment it's´incredibly easy to understand - level one economics, simple supply and demand, it really is a no nonsense investment, an appreciating asset that historically performs best in times of uncertainty
 


</div>
<div id="content5" class="content hidden">

  
<p>
One of the things we hear most is people don't have the time to properly look at ideas - because they get bombarded with too much information .. Is it the same for you..

Ok our service is designed for busy people - we carry out due diligence on all the companies we introduce, we employ risk experts to write balanced overviews of the investment ideas 
and we produce easy to watch 2 minute animation videos to provide a visual guide

Let me be direct, would you be happy with 16% per year return on an investment?
So would a source of  accurate and up to date information that you could trust be of real value, in terms of being able to make informed opinions?
Ok - so the only thing we ask is that you take 30 minutes to review what we send you - 

Because if we CAN introduce ideas  that have the security, growth and track record you are looking for. That would be of REAL value wouldn´t it?

Ok, well let me give you a bit more information about the wine : Investment Grade wine is always stored in a bonded warehouse and is fully insured at current market value. For most of our subscribers, in the current climate, Security has extra importance -  they want to make sure their money is safe… so they really like that aspect of it.. 

The typical way to invest is through an established and reputable broker, they advise clients on which wines to buy and when to sell in order to receive the highest levels of appreciation. And I´m not sure if you are aware, when it´s time to exit, all gains are exempt from capital gains tax..


</p>
  

</div>
<div id="content6" class="content hidden">
<p>
So from all the features  ( list them)
A The returns
B The security
C Capital Gains tax exemption
D Growth
what is the most attractive feature for you personally

We commissioned one of the UK´s leading risk experts to produce an independent report into the Fine Wine Sector - It is very balanced and covers all the risks as well as the benefits, so  I would like to send that to you and introduce you to our partner, UKV, who are an established independent Wine Broker and have PLC status. They generated 16% returns last year for their clients. 
They would like to post you their brochure, DVD and a complimentary bottle of wine as a thank you for taking the time to look at their company.

</p>

</div>
<div id="content7" class="content hidden">
<p>
 On face value, could this be an investment that would increase performance and add diversification to your portfolio and are you happy for me to send the info and make an introduction? 

Great, Before they call, they will send you an email with a short 3 minute video of a recent client event. They will invite you to one of these events where you can meet existing clients and speak to analysts.It also explains about the tax free returns. Please check your spam folder in case is goes there.

Now, I just need to ask you a couple of questions for compliance reasons if you don´t mind.:

The maximum investment level for new clients is 20,000 pounds and the minimum investment level is 5,000 pounds. Can I confirm that amount would be a comfortable level for you… if of course it ticked all the right boxes?

And..we only provide reports to High Net Worth individuals or sophisticated investors.There are many definitions but the simplest is : someone who has over £250k of assets aside from their home, this can include buy to lets, OR has made alternative investments in the past, OR earns 100K a year plus - I don’t need any details but can you confirm you fit into at least one of those categories.

Thank you, what I will do then is get a representative from UKV plc to give you a call to introduce themselves and arrange to get the wine, DVD and brochure posted. Would that be OK?

How is your schedule Mr --- when is normally the most convenient time for them to call and speak with you for a few moments? (Find out if he is a 9-5 / evening and get MEMORABLE WORD)

CONFIRM EMAIL ADDRESS. POSTAL ADDRESS & ALTERNATIVE NUMBER.
 
Before you go Mr.. and this is just so that we can continue to introduce suitable ideas in the future:
1)  what´s  been your best performing or favourite investment over the last 5 years or so..?
2)    What made you choose that investment out of interest?
3)    If you could improve one thing about your current portfolio or even that investment what would it be in an ideal world? And lastly...
4)    What´s more important to you in this day and age.. Security or growth?


Brilliant, thanks for your time….. We´ll get our report through to you today and UKV will call you (confirm time) We´ll also send you through our monthly newsletter and updates from time to time and if it´s OK with you I will give you a call in a month or so to get your feedback.. Would that ok?

 </p>
</div>
<div id="content8" class="content hidden">

<p>

  I know that you are not interested in XYZ 
OR 
I know that you are too busy today..

So what I would like to do is send you… an overview of our platform, newsletter and an example of one of our reports…then I can maybe give you a ring back in a couple of weeks to get your feedback? Would that be ok?

Can I ask you a quick question before I let you go?

What do you know about the secondary private placement market in the UK?

As an example, we have a company with a patented and tested technology which reduces  the carbon emissions and running costs of haulage trucks and industrial machinery by up to 30%

The research and development partner is one of the top 5 electronics companies in the world, they turn over half a billion a year and the CEO is a former member of the Bank of England committee -

Through our introduction you are able to benefit from 10% discount on the share price.  Would you like to receive information on that?

OK ... HNW / Soph investor confirmation 
Entry level is 20,000 - is that affordable to you?

Ok … what I can do is send you our guide to the secondary private placement market, an overview of the investment and a non disclosure agreement..

If you decide you wanted to look at the financials and all the due diligence documents then you would need to sign that in order to have access to the data room. 

Before doing that I would suggest having a chat with Chris or Tony who are the executives overseeing the project.

Would you like to me to send you the info and arrange for one of the guys to give you a bell in the next few days?

</p>

  
</div>
<div id="content10" class="content hidden">

  

</div>
<div id="content11" class="content hidden">

 

</div>
<div id="content12" class="content hidden">

 

</div>
-->
</div>
</div>

<hr />

