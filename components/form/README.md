# FormControl

Komponenta na načítavanie formulárov

Načítava formulárové kontainery v správnom poradí a vykresľuje ich pomocou `latte` templatov ktoré je možné si nadizajnovať.

## Použitie v latte

```
{control form-shopProductForm}
```

## Ak chceme upraviť FormGroup

V render metóde v presentri vieme nájsť formulár, jeho group a doplniť parametre


```
$this->getFormGroup('shopProductForm', 'Category')->setOption('container', \Nette\Utils\Html::el('div')->setClass('panel panel-primary'));
```
