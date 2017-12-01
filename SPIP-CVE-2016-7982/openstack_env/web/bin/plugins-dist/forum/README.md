# README

Quelques notes de documentation.

## Modèle de données

Pour expliquer la façon dont le plugin __forum__ stocke les messages de forums, prenons la conversation suivante :

 * à 12:53, envoi du message `msg A`
 * à 13:44, envoi du message `msg B`
 * à 14:27, envoi d'une réponse au premier message : `[Re] msg A`
 * à 18:12, envoi d'une réponse à cette réponse : `[Re] [Re] msg A`

### Table `spip_forum` dans la base de données

Les données sont stockées dans la table `spip_forum`, avec un message par ligne. La conversation donnera donc la table suivante (on ne montre que les champs principaux) :

| `id_forum` | `id_parent` | `id_thread` | `date_heure` | `date_thread` | `texte`           |
| ---------- | ----------- | ----------- | ------------ | ------------- | -------           |
| 1          | 0           | 1           | 12:53        | 18:12         | msg A             |
| 2          | 0           | 2           | 13:44        | 13:44         | msg B             |
| 3          | 1           | 1           | 14:27        | 18:12         | [Re] msg A        |
| 4          | 3           | 1           | 18:12        | 18:12         | [Re] [Re] msg A   |

Détaillons un peu le rôle de chaque champ :

| champ         | description                                                                       |
| -----         | -----------                                                                       |
| `id_forum`    | identifiant du message                                                            |
| `id_parent`   | identifiant du message parent pour les réponses, ou 0 si c'est le premier message |
| `id_thread`   | identifiant du premier message d'un thread                                        |
| `date_heure`  | heure du message (format un peu simplifié pour faire court)                       |
| `date_thread` | heure du dernier message du thread                                                |

A noter également les deux champs `id_objet` et `objet` qui indiquent l'objet auquel le message est attaché (ex: `id_objet = 3` et `objet = article` pour un message de forum dans l'article numéro 3).

### Relations entre `id_forum`, `id_parent` et `id_thread`

```
  msg A
  id_forum = 1            <---------+
  id_parent = 0                     |
  id_thread = 1            ---------+
                                    |
    [Re] msg A                      |
    id_forum = 3          <----+    |
    id_parent = 1          ----|----+
    id_thread = 1          ----|----+
                               |    |
      [Re] [Re] msg A          |    |
      id_forum = 4             |    |
      id_parent = 3        ----+    |
      id_thread = 1        ---------+

  msg B
  id_forum = 2            <----+
  id_parent = 0                |
  id_thread = 2            ----+
```

### Relations entre `date_heure` et `date_thread` :

```
  msg A
  date_heure = 12:53
  date_thread = 18:12      ----+
                               |
    [Re] msg A                 |
    date_heure = 12:53         |
    date_thread = 18:12    ----+
                               |
      [Re] [Re] msg A          |
      date_heure = 18:12  <----+
      date_thread = 18:12  ----+

  msg B
  date_heure = 13:44      <----+
  date_thread = 13:44      ----+
```
