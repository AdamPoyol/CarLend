var citroen = 0;
var peugeot = 0;

function AdaptationModele(element)
{
  baliseSelectMarque = document.getElementById('marque');
   baliseSelectMarque.value = element;
  baliseSelectModele = document.getElementById('modele');
  tab_citroen = ["C1", "C2", "C3", "C3 Picasso","C4", "C4 Picasso", "..."];
  tab_peugeot = ["206", "207", "207+", "..."];

    if (baliseSelectMarque.value == "citroen")
    {
      citroen ++;
      for (i=0; i<tab_citroen.length; i++)
      {
        var baliseOption = document.createElement("option");
        baliseOption.setAttribute('id','modele'+i);
        baliseOption.innerHTML =tab_citroen[i];
        baliseSelectModele.appendChild(baliseOption);
      }
    }
    else
    {
      if (citroen == 1)
      {
        citroen = 0;
        for (i=0; i<tab_citroen.length; i++)
        {
          baliseSelectModele.removeChild(document.getElementById('modele'+i));
        }
      }
    }

    if (baliseSelectMarque.value == "peugeot")
    {
      peugeot ++;
      for (i=0; i<tab_peugeot.length; i++)
      {
        var baliseOption = document.createElement("option");
        baliseOption.setAttribute('id','modele'+i);
        baliseOption.innerHTML =tab_peugeot[i];
        baliseSelectModele.appendChild(baliseOption);
      }
    }
    else
    {
      if (peugeot == 1)
      {
        peugeot = 0;
        for (i=0; i<tab_peugeot.length; i++)
        {
          baliseSelectModele.removeChild(document.getElementById('modele'+i));
        }
      }
    }
}
