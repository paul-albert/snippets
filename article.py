# Model for articles entity

from sqlalchemy import Column
from sqlalchemy.orm import relationship
from sqlalchemy.types import Float, Integer, String

from . import db, MixinModel


class Article(db.Model, MixinModel):
    """
    Model for Article.
    """
    __tablename__ = 'articles'

    id = Column('id', Integer, primary_key=True)
    SKU = Column('SKU', String(255))
    EAN = Column('EAN', String(255))
    name = Column('name', String(255))
    stock_quantity = Column('stock_quantity', Integer)
    price = Column('price', Float)

    articles_categories = relationship('ArticleCategory',
                                       backref='articles_categories',
                                       cascade='all, delete, delete-orphan')

    def get_articles_categories(self):
        """
        Get articles-categories mappings for given row of Article.

        :return: articles-categories mappings list
        :rtype:  list
        """
        return \
            [ac.to_dict() for ac in self.articles_categories] if self.id is not None \
            else []
