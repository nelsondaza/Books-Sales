# Database Structure

## Books
- id **[PK]**
- author _(string)_
- title _(string)_
- reference _(string)_
- units_available _(int >= 0)_
- price _(float >= 0)_
- published_at _(timestamp)_
- created_at _(timestamp)_
- modified_at _(timestamp)_

## Sales
- id **[PK]**
- book_id **[FK - Book]**
- price _(float >= 0)_
- created_at _(timestamp)_
- modified_at _(timestamp)_

