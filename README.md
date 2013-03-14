# Statistical Classifier

**This project is a work in progress**

## What is statistical classification?

> In machine learning and statistics, classification is the problem of identifying to which of a set of categories (sub-populations) a new observation belongs, on the basis of a training set of data containing observations (or instances) whose category membership is known. - [Wikipedia - Statistical Classification](http://en.wikipedia.org/wiki/Statistical_classification)

This library provides a statistical classifier written entirely in PHP. The project is written with a focus on reuse and customaizability. Using dependancy injection and interfaces, all components can be easily swapped out for your own version, or entirely new classifiers can be built.

By default a Naive Bayes classifier is provided which performs well on the [20 Newsgroups Data Set](http://qwone.com/~jason/20Newsgroups/). This classifier was built using a paper *[Tackling the Poor Assumptions of Naive Bayes Text Classifiers](resources/Tackling the Poor Assumptions of Naive Bayes Text Classifiers.pdf)* by Jason Rennie.

## Overview

A classifier is built using the following separate components:

| Component | Interface | Description |
| --------- | --------- | ----------- |
| Generic Classifier | ClassifierInterface | Acts as a base that other components are added to to build a classifier |
| Data Source | DataSourceInterface | Multiple available, they provide the raw training data to the classifier |
| Index | IndexInterface | This stores the results of each transform and is eventually the thing that is cached |
| Normalizer | NormalizerInterface | Takes an array of words and makes them more consistent, for example, lowercase, porter stemmed |
| Tokenizer | TokenizerInterface | Breaks up a string into tokens |
| Transforms | TransformInterface | Manipulates the Index to produce data ready for a classification rule |
| Classification rule | ClassificationRuleInterface | Uses the index prepared by the transforms and the data source to classify a document |

## Installation (with composer)

### For your application

    $ composer requre camspiers/statistical-classifier:~0.1

### For command-line use

	$ composer create-project camspiers/statistical-classifier .
	$ ln -s $PWD/bin/statistical-classifier /usr/local/bin/statistical-classifier

## Dependancy injection (Symfony)

This library uses Symfony's dependancy injection component. A container extension is provided, and a container is also provided so if you aren't using Symfony's dependancy injection component you can still take advantage of the default services provided.

## Usage

### From within external PHP code

#### Using the service container provided

```
<?php
// Ensure composer autoloader is required
$container = new StatisticalClassifierServiceContainer;
// Using a plain data array source for simplicity
use Camspiers\StatisticalClassifier\DataSource\DataArray;
// This sets the data source to the soon created classifier using a synthetic symfony service
$container->set(
    'data_source.data_source',
    new DataArray(
        array(
            'spam' => array(
                'Some spam document',
                'Another spam document'
            ),
            'ham' => array(
                'Some ham document',
                'Another ham document'
            )
        )
    )
);
$classifier = $container->get('classifier.naive_bayes');
echo $classifier->classify('Some ham document'), PHP_EOL; // ham
```

#### Building your own

```
<?php
// Ensure composer autoloader is required
use Camspiers\StatisticalClassifier;
$classifier = new Classifier\NaiveBayes(
    new DataSource\DataArray(
        array(
            'spam' => array(
                'Some spam document',
                'Another spam document'
            ),
            'ham' => array(
                'Some ham document',
                'Another ham document'
            )
        )
    ),
    new Index\Index(),
    new Tokenizer\Word(),
    new Normalizer\Lowercase()
);
echo $classifier->classify('Some ham document'), PHP_EOL; // ham
```


### Command-line executable

    $ statistical-classifier train -c ham -t Directory ./ham
    $ statistical-classifier train -c spam -t Directory ./spam
    $ statistical-classifier classify "Some test document"

## Internals

### Classifiers

* Generic Classifier
* Naive Bayes Classifier

### Data Sources

* DataArray
* Directory
* Json
* PDO
* PDOQuery
* Serialized

### Index

* Index
* CachedIndex

### Normalizers

* Lowercase
* Porter
* Stopword

### Tokenizers

* Word

### Tranforms

* Complement
* DC
* DL
* DocumentTokenCounts
* DocumentTokenSums
* IDF
* Prune
* TAC
* TBC
* TCBD
* TF
* TFIDF
* TFThreaded
* TransformInterface
* Weight
* WeightNormalization

### Classification Rules

* NaiveBayes

