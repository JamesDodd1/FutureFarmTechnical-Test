# FutureFarm Technical Test

### Technologies
- PHP
- MySQL


### Assumptions
- A field may only every have one crop at a time.
- Fields will keep the same crops types.
- Each crop type may only ever have one chemical used on it.
- If multiple fields are using the same chemical and will be purchased at the same time, that batch will be applied to all relevent fields.
- Any fields whose chemical application duration has expired or the end date is less than one week away, the purchase date is set to today.
- The day first day the spray duration expires will be the expected day to reapply the chemicals.
- Only the latest spray date needs to remembered.


### Entity Relationship Diagram
![ERD](./images/ERD.jpeg)


### Output Data
<img src="./images/OutputArray.jpeg" alt="OutputData" width="250" />

__Note:__ Each chemical type had at least one crop whose spray end date has elapsed, therefore all 'Date to buy' value are all set to today's date
